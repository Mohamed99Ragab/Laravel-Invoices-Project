<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArchiveInvoicesController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceAttachementController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('auth.login');
})->middleware('guest');


Auth::routes(['register'=>false]);


Route::group(['middleware' => ['auth','status']], function() {

    //dashboard
    Route::get('/dashboard',[HomeController::class,'index'])->name('dashboard');


    //invoices
    Route::get('/section/{id}',[InvoiceController::class,'getProduct']);

    Route::get('invoices/paid',[InvoiceController::class,'invoices_paid'])->name('invoices_paid');
    Route::get('invoices/unpaid',[InvoiceController::class,'invoices_unpaid'])->name('invoices_unpaid');
    Route::get('invoices/partial',[InvoiceController::class,'invoices_partial'])->name('invoices_partial');
    Route::resource('/invoices',InvoiceController::class);

//sections
    Route::resource('/sections',SectionController::class);

//products
    Route::resource('/products',ProductController::class);

//invoices details
    Route::get('/downloadFile/{invoice_number}/{file_name}',[InvoiceAttachementController::class,'download_file'])->name('download_file');
    Route::post('/statusUpdate',[InvoiceController::class,'statusUpdate'])->name('statusUpdate');
    Route::resource('/InvoiceDetails',InvoiceDetailsController::class);


//invoices attachments
    Route::get('delteFile/{invoice_number}/{file_name}/{id}',[InvoiceAttachementController::class,'delete_file'])->name('delete_file');
    Route::resource('/InvoiceAttachment',InvoiceAttachementController::class);


//******* Invoices Archive
    Route::resource('invoicesArchive',ArchiveInvoicesController::class);

// print invoice
    Route::get('printInvoice/{id}',[InvoiceController::class,'print_invoice']);

//export invoices in excel sheet
    Route::get('export/',[InvoiceController::class,'exportInvoices'])->name('exportInvoices');



    Route::resource('roles', RoleController::class);
    Route::post('EditUser',[UserController::class,'EditUser'])->name('EditUser');
    Route::resource('users', UserController::class);
    // Invoices Reports
    Route::get('invoices_roports/',[Invoices_Report::class,'index'])->name('invoices_roports');
    Route::post('Search_invoices/',[Invoices_Report::class,'Search_invoices'])->name('Search_invoices');

// customers Reports
    Route::get('customers_reports/',[Customers_Report::class,'index'])->name('customers_reports');
    Route::post('Search_customers/',[Customers_Report::class,'Search_customers'])->name('Search_customers');


    //notifications
    Route::get('MarkAll_Notify',[InvoiceController::class,'Mark_as_read'])->name('Mark_as_read');





});



Route::get('/{page}', [AdminController::class,'index']);
