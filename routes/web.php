<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VendorController;

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

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');

    // Inventory Management Routes
    Route::get('/inventory/list', 'RoutesController@inventoryList')->name('inventory.list');
    Route::get('/inventory/transfer', 'RoutesController@inventoryTransfer')->name('inventory.transfer');
    Route::get('/inventory/withdrawal', 'RoutesController@inventoryWithdrawal')->name('inventory.withdrawal');
    Route::get('/inventory/returned', 'RoutesController@inventoryReturned')->name('inventory.returned');

    // Equipment & Asset Management Routes
    Route::get('/equipment/list', 'RoutesController@equipmentList')->name('equipment.list');
    Route::get('/equipment/transfer', 'RoutesController@equipmentTransfer')->name('equipment.transfer');
    Route::get('/equipment/disposal', 'RoutesController@equipmentDisposal')->name('equipment.disposal');
    
    // UOM
    Route::get('/settings/uom', 'UomController@index')->name('settings.uom');
    Route::post('store_uom','UomController@store');

    // Category
    Route::get('/settings/category', 'CategoryController@index')->name('category');
    Route::post('store_category','CategoryController@store');
    Route::post('update_category/{id}','CategoryController@update');

    // Roles and Permissions
    Route::get('/settings/roles', 'PermissionController@index')->name('settings.roles');
    Route::post('store_role','PermissionController@storeRole');
    Route::post('update_role/{id}','PermissionController@updateRole');
    Route::post('activate_role/{id}','PermissionController@activateRole');
    Route::post('deactivate_role/{id}','PermissionController@deactivateRole');

    // Users
    Route::get('/settings/users', 'UserController@index')->name('settings.users');
    Route::post('store_users', 'UserController@store');
    Route::post('update_users/{id}','UserController@update');
    Route::post('activate_user/{id}','UserController@activate');
    Route::post('deactivate_user/{id}','UserController@deactivate');

    // Company
    Route::get('/settings/company', 'CompanyController@index')->name('settings.company');
    Route::post('create-company', 'CompanyController@createCompany')->name('create-company');
    Route::post('update-company/{id}', 'CompanyController@update');
    Route::post('deactivate_company/{id}', 'CompanyController@deactivate');
    Route::post('activate_company/{id}', 'CompanyController@activate');

    // Department
    Route::get('/settings/department','DepartmentController@index')->name('settings.department');
    Route::post('/settings/store-department','DepartmentController@store');
    Route::post('/settings/update-department/{id}','DepartmentController@update');
    Route::post('/settings/active-department/{id}','DepartmentController@active');
    Route::post('/settings/deactive-department/{id}','DepartmentController@deactive');

    // Purchased Request
    Route::get('procurement/purchase-request', 'PurchaseRequestController@index')->name('procurement.purchase_request');
    Route::get('procurement/show-purchase-request/{id}','PurchaseRequestController@show');
    Route::post('procurement/store-purchase-request','PurchaseRequestController@store');
    Route::post('procurement/update-purchase-request/{id}','PurchaseRequestController@update');
    Route::post('procurement/update-files/{id}','PurchaseRequestController@updateFiles');
    Route::post('procurement/delete-files/{id}','PurchaseRequestController@deleteFiles');
    Route::post('procurement/edit-assigned/{id}', 'PurchaseRequestController@editAssigned');
    Route::post('refresh_vendor_email', 'PurchaseRequestController@refreshVendorEmail')->name('refresh_vendor_email');
    Route::post('return_purchase_request/{id}','PurchaseRequestController@return');
    Route::post('refresh_inventory', 'PurchaseRequestController@refreshInventory')->name('refreshInventory');

    // For Approval
    Route::get('procurement/for-approval-pr', 'ForApprovalPurchaseRequestController@index')->name('procurement.for_approval_pr');
    Route::post('procurement/action/{id}', 'ForApprovalPurchaseRequestController@update');
    
    // Request For Quotation
    Route::post('store-request-for-quotation', 'RequestForQuotationController@store');

    // Purchased Order
    Route::get('procurement/purchase-order', 'PurchaseOrderController@index')->name('procurement.purchase_order');
    Route::post('procurement/store_purchase_order', 'PurchaseOrderController@store');
    Route::get('procurement/show_purchase_order/{id}','PurchaseOrderController@show');
    Route::post('refresh_rfq_vendor', 'PurchaseOrderController@refreshRfqVendor');

    // Vendors
    Route::get('/settings/vendors', 'VendorController@index')->name('settings.vendors');
    Route::post('/settings/store-vendor','VendorController@store');
    Route::get('/settings/view_vendor/{id}','VendorController@show');
    Route::post('/settings/edit-vendor/{id}','VendorController@update');
    Route::post('/settings/refresh_vendor_code','VendorController@refreshVendorCode')->name('refreshVendorCode');
  
    // Canvassing
    Route::get('procurement/canvassing', 'CanvassingController@index')->name('procurement.canvassing');

    // Supplier Accreditation
    Route::get('procurement/supplier_accreditation', 'AccreditationController@index')->name('procurement.supplier_accreditation');
    Route::get('supplier_accreditation/create', 'AccreditationController@create');
    Route::post('procurement/store_supplier_accreditation','AccreditationController@store')->name('supplier_accreditation.store');
    Route::get('procurement/view_supplier_accreditation/{id}','AccreditationController@view');
    Route::get('procurement/edit_supplier_accreditation/{id}', 'AccreditationController@edit')->name('supplier_accreditation.edit');
    Route::post('procurement/update_supplier_accreditation/{id}','AccreditationController@update');
    Route::post('procurement/approved_supplier_accreditation/{id}','AccreditationController@approved');
    Route::post('procurement/declined_supplier_accreditation/{id}','AccreditationController@declined');

    // Supplier Evaluation
    Route::get('procurement/supplier_evaluation', 'EvaluationController@index')->name('procurement.supplier_evaluation');
    Route::post('procurement/store_supplier_evaluation','EvaluationController@store');
    Route::get('procurement/view_supplier_evalutaion/{id}','EvaluationController@view');
    Route::post('procurement/update_supplier_evalutaion/{id}','EvaluationController@update');
    Route::post('refresh_vendor_name', 'EvaluationController@refreshVendorName')->name('refresh_vendor_name');
    Route::post('procurement/confirmed_supplier_evaluation/{id}','EvaluationController@confirmed');
});