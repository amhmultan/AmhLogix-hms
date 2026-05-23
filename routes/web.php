<?php


use App\Http\Controllers\Admin\PurchaseInvoiceController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\NoteController;
use App\Http\Controllers\Admin\PatientController;
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
    
    // AJAX routes for Select2 product search
    Route::get('/products/ajax', [PurchaseInvoiceController::class, 'getProductsAjax'])->name('products.ajax');
    Route::get('/products/ajax', [SaleController::class, 'getProductsAjax'])->name('products.ajax');
    
    // AJAX routes for products
    Route::get('products-data', [App\Http\Controllers\Admin\ProductController::class, 'getProducts'])->name('products.data');
    Route::get('products-search', [App\Http\Controllers\Admin\ProductController::class, 'search'])->name('products.search');

    Route::get('/doctor-notes/products/search', [App\Http\Controllers\Admin\DoctorNotesController::class, 'searchProducts'])
        ->name('doctor_notes.products.search');

    // AJAX route for patients
    Route::get('patients/data', [PatientController::class, 'getData'])->name('patients.data');

    // Token reports
    Route::get('/tokens/token-report', [App\Http\Controllers\Admin\TokenReportController::class, 'index'])->name('tokens.token_report');
    Route::get('/tokens/token-report/data', [App\Http\Controllers\Admin\TokenReportController::class, 'data'])->name('tokens.token_report.data');
    Route::get('/tokens/token-report/pdf', [App\Http\Controllers\Admin\TokenReportController::class, 'reportPdf'])->name('tokens.token_report.pdf');

    // Resources
    Route::resource('purchases', App\Http\Controllers\Admin\PurchaseInvoiceController::class);
    Route::resource('roles', App\Http\Controllers\Admin\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\Admin\PermissionController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::resource('hospitals', App\Http\Controllers\Admin\HospitalController::class);
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
    Route::resource('patients', App\Http\Controllers\Admin\PatientController::class);
    Route::resource('tokens', App\Http\Controllers\Admin\TokenController::class);
    Route::resource('manufacturers', App\Http\Controllers\Admin\ManufacturerController::class);
    Route::resource('suppliers', App\Http\Controllers\Admin\SupplierController::class);
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::resource('pharmacies', App\Http\Controllers\Admin\PharmacyController::class);
    Route::resource('doctor_notes', App\Http\Controllers\Admin\DoctorNotesController::class);
    Route::resource('sales', App\Http\Controllers\Admin\SaleController::class);
    Route::resource('specialities', App\Http\Controllers\Admin\SpecialityController::class);
    Route::resource('doctors', App\Http\Controllers\Admin\DoctorController::class);
    Route::resource('appointments', App\Http\Controllers\Admin\AppointmentController::class);
    Route::resource('dosages', App\Http\Controllers\Admin\DosageController::class);

    // Custom prints
    Route::get('purchases/{purchase}/print', [App\Http\Controllers\Admin\PurchaseInvoiceController::class, 'print'])->name('purchases.print');
    Route::get('sales/{sale}/print', [App\Http\Controllers\Admin\SaleController::class, 'print'])->name('sales.print');
    Route::get('doctor_notes/{id}/print', [App\Http\Controllers\Admin\DoctorNotesController::class, 'print'])->name('doctor_notes.print');
    Route::get('patients/{id}/print', [App\Http\Controllers\Admin\PatientController::class, 'print'])->name('patients.print');

    // Stock reports
    Route::get('reports', [App\Http\Controllers\Admin\StockReportController::class, 'index'])->name('reports.index');
    Route::get('reports/print', [App\Http\Controllers\Admin\StockReportController::class, 'print'])->name('reports.print');

    // Backup system
    Route::get('backups', [App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backups.index');
    Route::post('backups', [App\Http\Controllers\Admin\BackupController::class, 'create'])->name('backups.create');
    Route::get('backups/download/{fileName}', [App\Http\Controllers\Admin\BackupController::class, 'download'])->name('backups.download');
    Route::delete('backups/delete/{fileName}', [App\Http\Controllers\Admin\BackupController::class, 'delete'])->name('backups.delete');
    Route::post('backups/restore/{fileName}', [App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backups.restore');

    // IPD Dashboard
    Route::get('ipd', [App\Http\Controllers\Admin\AdmissionController::class, 'ipdDashboard'])->name('ipd.index');
    
    // IPD Admissions
    Route::resource('admissions', App\Http\Controllers\Admin\AdmissionController::class);
    Route::get('admissions/{admission}/print-slip', [App\Http\Controllers\Admin\AdmissionController::class, 'printSlip'])
    ->name('admissions.print');
    
    // Bed & Ward Management
    Route::resource('wards', App\Http\Controllers\Admin\WardController::class);
    Route::resource('beds', App\Http\Controllers\Admin\BedController::class);
    Route::post('beds/{admission}/shift', [App\Http\Controllers\Admin\BedController::class, 'shift'])->name('beds.shift');

    // Daily Notes & Vitals
    Route::prefix('daily-notes')->name('daily-notes.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\NoteController::class, 'index'])->name('index');
        
        // Custom create route with admission
        Route::get('/create/{admission}', [App\Http\Controllers\Admin\NoteController::class, 'create'])
            ->name('create');

        Route::post('/', [App\Http\Controllers\Admin\NoteController::class, 'store'])->name('store');
        
        Route::get('/{dailyNote}/edit', [App\Http\Controllers\Admin\NoteController::class, 'edit'])->name('edit');
        Route::put('/{dailyNote}', [App\Http\Controllers\Admin\NoteController::class, 'update'])->name('update');
        Route::delete('/{dailyNote}', [App\Http\Controllers\Admin\NoteController::class, 'destroy'])->name('destroy');
    });

    // Charges & Billing
    Route::resource('charges', App\Http\Controllers\Admin\ChargeController::class);
    Route::get('admissions/{admission}/bill', [App\Http\Controllers\Admin\ChargeController::class, 'bill'])
        ->name('admissions.bill');
    
    // Discharge
    Route::get('admissions/{admission}/discharge', [App\Http\Controllers\Admin\DischargeController::class, 'create'])
    ->name('admissions.discharge');
    Route::post('admissions/{admission}/discharge', [App\Http\Controllers\Admin\DischargeController::class, 'store'])
        ->name('admissions.discharge.store');
    Route::get('admissions/{admission}/discharge-slip', [App\Http\Controllers\Admin\DischargeController::class, 'printSlip'])
    ->name('admissions.discharge-slip');
    
    // IPD Reports
    Route::get('ipd-reports', [App\Http\Controllers\Admin\IPDReportController::class, 'index'])->name('ipd.ipd_reports.index');
});