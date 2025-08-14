<?php


use App\Http\Controllers\Admin\PurchaseInvoiceController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StockReportController;
use App\Http\Controllers\Admin\TokenReportController;
use App\Http\Controllers\Admin\BackupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Public routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/service', function () {
    return view('service');
});

Route::get('/doctor', function () {
    return view('doctor');
});

Route::get('/doctor-single', function () {
    return view('doctor-single');
});

Route::get('/department-single', function () {
    return view('department-single');
});

Route::get('/department', function () {
    return view('department');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/confirmation', function () {
    return view('confirmation');
});

Route::get('/blog-single', function () {
    return view('blog-single');
});

Route::get('/blog-sidebar', function () {
    return view('blog-sidebar');
});

Route::get('/appointment', function () {
    return view('appointment');
});

// Front auth routes
Route::get('/dashboard', function () {
    return view('front.dashboard');
})->middleware(['front'])->name('dashboard');


require __DIR__.'/front_auth.php';


// Admin routes

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('admin.dashboard');

require __DIR__.'/auth.php';

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('roles','App\Http\Controllers\Admin\RoleController');
    Route::resource('permissions','App\Http\Controllers\Admin\PermissionController');
    Route::resource('users','App\Http\Controllers\Admin\UserController');
    Route::resource('hospitals','App\Http\Controllers\Admin\HospitalController');
    Route::resource('posts','App\Http\Controllers\Admin\PostController');
    Route::resource('patients','App\Http\Controllers\Admin\PatientController');
    Route::get('/tokens/token-report', [TokenReportController::class, 'index'])
    ->name('tokens.token_report');
    Route::get('/tokens/token-report/data', [TokenReportController::class, 'data'])
        ->name('tokens.token_report.data');
    Route::resource('tokens','App\Http\Controllers\Admin\TokenController');
    Route::resource('manufacturers','App\Http\Controllers\Admin\ManufacturerController');
    Route::resource('suppliers','App\Http\Controllers\Admin\SupplierController');
    Route::resource('products','App\Http\Controllers\Admin\ProductController');
    Route::resource('pharmacies','App\Http\Controllers\Admin\PharmacyController');
    Route::resource('doctor_notes','App\Http\Controllers\Admin\DoctorNotesController');
    // Extra route for printing doctor notes
    Route::get('doctor_notes/{id}/print', [App\Http\Controllers\Admin\DoctorNotesController::class, 'print'])
        ->name('doctor_notes.print');
    Route::resource('sales','App\Http\Controllers\Admin\SaleController');
    Route::resource('specialities','App\Http\Controllers\Admin\SpecialityController');
    Route::resource('doctors','App\Http\Controllers\Admin\DoctorController');
    Route::resource('appointments','App\Http\Controllers\Admin\AppointmentController');
    Route::resource('purchases','App\Http\Controllers\Admin\PurchaseInvoiceController');

    // Custom prints
    Route::get('purchases/{purchase}/print', [PurchaseInvoiceController::class, 'print'])->name('purchases.print');
    Route::get('sales/{sale}/print', [SaleController::class, 'print'])->name('sales.print');

    // Reports
    Route::get('reports', function () {
        return view('reports.index');
    })->name('reports.index');

    Route::get('reports', [StockReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [StockReportController::class, 'print'])->name('reports.print');

    // Backup System Routes
    Route::get('backups', [BackupController::class, 'index'])->name('backups.index');
    Route::post('backups', [BackupController::class, 'create'])->name('backups.create');
    Route::get('backups/download/{fileName}', [BackupController::class, 'download'])->name('backups.download');
    Route::delete('backups/delete/{fileName}', [BackupController::class, 'delete'])->name('backups.delete');
    Route::post('backups/restore/{fileName}', [BackupController::class, 'restore'])->name('backups.restore');
    
});