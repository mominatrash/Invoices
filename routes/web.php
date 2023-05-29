<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerReportsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoicesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

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
    return view('index');
})->middleware('auth');



Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::get('/{page}', [AdminController::class, 'index']);








//Route::get('/edit_s/{id}', [SectionController::class, 'edit_s'])->name('edit_s')->middleware('auth');



















Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/index', [AdminController::class, 'index'])->name('index')->middleware('auth');
    Route::get('/invoices', [AdminController::class, 'invoices'])->name('invoices')->middleware('permission:الفواتير');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
    Route::post('/insert', [AdminController::class, 'insert'])->name('insert');
    Route::post('/update', [AdminController::class, 'update'])->name('update');
    Route::post('/delete', [AdminController::class, 'destroy']);



    Route::get('/create_invoice', [InvoiceController::class, 'create_invoice'])->name('create_invoice')->middleware('permission:اضافة فاتورة');
    Route::get('/get_products/{id}', [InvoiceController::class, 'get_products'])->name('get_products')->middleware('permission:المنتجات');
    Route::post('/store_invoice', [InvoiceController::class, 'store_invoice'])->name('store_invoice')->middleware('permission:اضافة فاتورة');
    Route::get('/edit_invoice/{id}', [InvoiceController::class, 'edit_invoice'])->name('edit_invoice')->middleware('permission:تعديل الفاتورة');
    Route::post('/update_invoice/{id}', [InvoiceController::class, 'update_invoice'])->name('update_invoice')->middleware('permission:تعديل الفاتورة');
    Route::post('/delete_invoice', [InvoiceController::class, 'delete_invoice'])->name('delete_invoice')->middleware('permission:حذف الفاتورة');
    Route::get('/show_status/{id}', [InvoiceController::class, 'show_status'])->name('show_status');
    Route::post('/status_update/{id}', [InvoiceController::class, 'status_update'])->name('status_update')->middleware('permission:تغيير حالة الدفع');
    Route::get('/invoices_paid', [InvoiceController::class, 'invoices_paid_status'])->name('invoices_paid')->middleware('permission:الفواتير المدفوعة');
    Route::get('/invoices_unpaid', [InvoiceController::class, 'invoices_paid_status'])->name('invoices_unpaid')->middleware('permission:الفواتير الغير مدفوعة');
    Route::get('/invoices_paritally_paid', [InvoiceController::class, 'invoices_paid_status'])->name('invoices_paritally_paid')->middleware('permission:الفواتير المدفوعة جزئيا');
    Route::post('/archive', [InvoiceController::class, 'archive'])->name('archive')->middleware('permission:ارشفة الفاتورة');
    Route::get('/archived_invoices', [InvoiceController::class, 'archived_invoices'])->name('archived_invoices')->middleware('permission:ارشيف الفواتير');
    Route::get('/print_invoice/{id}', [InvoiceController::class, 'print_invoice'])->name('print_invoice')->middleware('permission:طباعةالفاتورة');
    Route::get('export', [InvoiceController::class, 'export'])->name('export')->middleware('permission:تصدير EXCEL');




    Route::get('/invoice_details/{id}', [InvoiceDetailsController::class, 'invoice_details'])->name('invoice_details')->middleware('permission:الفواتير');
    Route::get('/View_file/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'View_file'])->name('View_file')->middleware('permission:الفواتير');
    Route::get('/download/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'download'])->name('download')->middleware('permission:الفواتير');
    Route::post('/delete_file', [InvoiceDetailsController::class, 'delete_file'])->name('delete_file')->middleware('permission:حذف المرفق');




    Route::get('/sections', [SectionController::class, 'sections'])->name('sections')->middleware('permission:الاقسام');
    Route::post('/insert_section', [SectionController::class, 'insert_section'])->name('insert_section')->middleware('permission:اضافة قسم');
    Route::get('/edit_s/{id}', [SectionController::class, 'edit_s'])->name('edit_s')->middleware('permission:تعديل قسم');
    Route::post('/update_section', [SectionController::class, 'update_section'])->name('update_section')->middleware('permission:تعديل قسم');
    Route::post('/section_delete', [SectionController::class, 'section_delete'])->name('section_delete')->middleware('auth')->middleware('permission:حذف قسم');




    Route::get('/products', [ProductController::class, 'products'])->name('products')->middleware('permission:المنتجات');
    Route::post('/insert_product', [ProductController::class, 'insert_product'])->name('insert_product')->middleware('permission:اضافة منتج');
    Route::post('/update_product', [ProductController::class, 'update_product'])->name('update_product')->middleware('permission:تعديل منتج');
    Route::post('/product_delete', [ProductController::class, 'product_delete'])->name('product_delete')->middleware('permission:حذف منتج');




    Route::get('/links', [LinkController::class, 'links'])->name('links')->middleware('auth');
    Route::post('/create_link', [LinkController::class, 'create_link'])->name('create_link')->middleware('auth');
    Route::match(['get', 'post'], '/sLink/{id}', [LinkController::class, 'sLink'])->name('sLink')->middleware('auth');
    Route::get('/link/{id}', [LinkController::class, 'sLink'])->name('link')->middleware('auth');
    Route::post('/delete_l', [LinkController::class, 'delete_l'])->middleware('auth');





    // permissions routes

    Route::get('/show_users', [UserController::class, 'show_users'])->name('show_users')->middleware('permission:المستخدمين');
    Route::get('/create_user', [UserController::class, 'create_user'])->name('create_user')->middleware('permission:اضافة مستخدم');
    Route::post('/store_user', [UserController::class, 'store_user'])->name('store_user')->middleware('permission:اضافة مستخدم');
    Route::get('/edit_user/{id}', [UserController::class, 'edit_user'])->name('edit_user')->middleware('permission:تعديل مستخدم');
    Route::post('/user_delete', [UserController::class, 'user_delete'])->name('user_delete')->middleware('permission:حذف مستخدم');
    Route::post('/update_user', [UserController::class, 'update_user'])->name('update_user')->middleware('permission:تعديل مستخدم');




    Route::get('/show_roles', [RoleController::class, 'show_roles'])->name('show_roles')->middleware('permission:عرض صلاحية');
    Route::get('/create_role', [RoleController::class, 'create_role'])->name('create_role')->middleware('permission:اضافة صلاحية');
    Route::post('/store_role', [RoleController::class, 'store_role'])->name('store_role')->middleware('permission:اضافة صلاحية');
    Route::post('/edit_role', [RoleController::class, 'edit_role'])->name('edit_role')->middleware('permission:تعديل صلاحية');
    Route::get('/delete_role/{id}', [RoleController::class, 'delete_role'])->name('delete_role')->middleware('permission:حذف صلاحية');
    Route::get('/show_details/{id}', [RoleController::class, 'show_details'])->name('show_details')->middleware('permission:عرض صلاحية');
    Route::get('/edit_role/{id}', [RoleController::class, 'edit_role'])->name('edit_role')->middleware('permission:تعديل صلاحية');
    Route::post('/roles_update', [RoleController::class, 'roles_update'])->name('roles_update')->middleware('permission:تعديل صلاحية');
    Route::post('/delete_role', [RoleController::class, 'delete_role'])->name('delete_role')->middleware('permission:حذف صلاحية');
    
    
    
    
    
    Route::get('/invoices_reports', [InvoicesReportController::class, 'invoices_reports'])->name('invoices_reports')->middleware('permission:التقارير');
    Route::post('/search_invoices', [InvoicesReportController::class, 'search_invoices'])->name('search_invoices')->middleware('permission:تقرير الفواتير');


    Route::get('/customers_reports', [CustomerReportsController::class, 'customers_reports'])->name('customers_reports')->middleware('permission:التقارير');
    Route::post('/search_customers', [CustomerReportsController::class, 'search_customers'])->name('search_customers')->middleware('permission:تقرير العملاء');


    // Route::resource('roles','RoleController');
    // Route::resource('users','UserController');

});
