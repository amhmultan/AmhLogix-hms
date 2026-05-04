<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    /**
     * Display a listing of the backup files.
     */
    public function index()
    {
        $backupFolder = 'AmhLogix';

        // Get all files in the backup folder
        $files = Storage::disk('local')->files($backupFolder);

        // Filter only .zip backup files
        $backups = array_filter($files, fn($file) => str_ends_with($file, '.zip'));

        // Map files to detailed info
        $backupFiles = array_map(function ($file) use ($backupFolder) {
            return [
                'name' => basename($file),
                'path' => $file,
                'size' => Storage::disk('local')->size($file),
                'last_modified' => Storage::disk('local')->lastModified($file),
            ];
        }, $backups);

        return view('backup.index', compact('backupFiles'));
    }

    /**
     * Create a new backup using the artisan command.
     */
    public function create()
    {
        try {
            Artisan::call('backup:run');
            return redirect()->route('admin.backups.index')->with('success', 'Backup created successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.backups.index')->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Download a backup file.
     */
    public function download(string $fileName)
    {
        $backupFolder = 'AmhLogix';
        $fileName = basename($fileName); // sanitize filename
        $filePath = $backupFolder . '/' . $fileName;

        if (!Storage::disk('local')->exists($filePath)) {
            abort(404, 'Backup file not found.');
        }

        return response()->download(storage_path('app/' . $filePath));
    }

    /**
     * Delete a backup file.
     */
    public function delete(string $fileName)
    {
        $backupFolder = 'AmhLogix';
        $fileName = basename($fileName); // sanitize filename
        $filePath = $backupFolder . '/' . $fileName;

        if (Storage::disk('local')->exists($filePath)) {
            Storage::disk('local')->delete($filePath);
            return redirect()->route('admin.backups.index')->with('success', 'Backup deleted successfully!');
        }

        return redirect()->route('admin.backups.index')->with('error', 'Backup file not found!');
    }

    public function restore($fileName)
    {
        $backupFolder = 'AmhLogix';

        $fileName = basename($fileName);
        $filePath = $backupFolder . '/' . $fileName;

        if (!Storage::disk('local')->exists($filePath)) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Backup file not found!');
        }

        $fullPath = storage_path('app/' . $filePath);

        $zip = new \ZipArchive;

        if ($zip->open($fullPath) !== true) {
            return redirect()->route('admin.backups.index')
                ->with('error', 'Failed to open backup file.');
        }

        $extractPath = storage_path('app/backup-temp');

        if (is_dir($extractPath)) {
            $this->deleteDirectory($extractPath);
        }

        mkdir($extractPath, 0755, true);

        $zip->extractTo($extractPath);
        $zip->close();

        $sqlFile = $this->findSqlFile($extractPath);

        if (!$sqlFile || !file_exists($sqlFile)) {
            $this->deleteDirectory($extractPath);

            return redirect()->route('admin.backups.index')
                ->with('error', 'SQL file not found in backup.');
        }

        // 🔥 SAFE RESTORE (NO MYSQL CLI)
        try {
            $sql = file_get_contents($sqlFile);

            if (!$sql) {
                throw new \Exception("SQL file is empty");
            }

            \DB::unprepared($sql);

        } catch (\Exception $e) {
            $this->deleteDirectory($extractPath);

            return redirect()->route('admin.backups.index')
                ->with('error', 'Restore failed: ' . $e->getMessage());
        }

        $this->deleteDirectory($extractPath);

        return redirect()->route('admin.backups.index')
            ->with('success', 'Database restored successfully!');
    }

    // Recursive function to find .sql file
    private function findSqlFile(string $dir): ?string
    {
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }
            $fullPath = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($fullPath)) {
                $found = $this->findSqlFile($fullPath);
                if ($found !== null) {
                    return $found;
                }
            } elseif (str_ends_with($file, '.sql')) {
                return $fullPath;
            }
        }
        return null;
    }

    // Recursive function to delete a directory
    private function deleteDirectory($dir)
    {
        if (!is_dir($dir)) {
            return;
        }
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }
        rmdir($dir);
    }


}
