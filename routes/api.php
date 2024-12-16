<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//Users
Route::post('register', 'Auth\RegisterController@register')->name('register');
Route::post('edit-user', 'UserController@updateUser')->name('edit-user');
Route::post('delete-user', 'UserController@deleteUser')->name('delete-user');

//Subsidiary
Route::post('create-company', 'CompanyController@createCompany')->name('create-company');
Route::get('company', 'CompanyController@index')->name('company');

//roles and permissions
Route::get('permissions', 'PermissionController@index')->name('permissions');
Route::get('features', 'PermissionController@getFeatures')->name('features');
Route::get('roles', 'PermissionController@getRoles')->name('roles');
Route::post('create-role', 'PermissionController@createRole')->name('create-role');
Route::post('create-permission', 'PermissionController@createPermission')->name('create-permission');
Route::patch('update-role/{id}', 'UserController@update')->name('update-role');
Route::get('users', 'UserController@index')->name('users');
Route::post('users/suggestions', 'UserController@getUserSuggestions')->name('user-role');
Route::post('delete-role', 'PermissionController@delete')->name('delete-role');

//inventory
Route::post('inventory', 'InventoryController@index')->name('inventory');
Route::get('subsidiary', 'InventoryController@getSubsidiary')->name('subsidiary');
Route::post('create-inventory', 'InventoryController@createInventory')->name('create-inventory');
Route::post('search-inventory', 'InventoryController@search')->name('search-inventory');

//inventory-transfer
Route::post('inventory/transfer/request', 'InventoryController@requestTransfer')->name('inventory.transfer.request');
Route::post('inventory/transfer/approve/{transferId}', 'InventoryController@approveTransfer')->name('inventory.transfer.approve');
Route::post('inventory/transfer/decline/{transactId}', 'InventoryController@declineTransfer')->name('inventory.transfer.decline');
Route::post('inventory/transfer', 'InventoryController@fetchTransfers')->name('inventory.transfer.fetch');
Route::get('inventory/search-item', 'InventoryController@searchItem')->name('inventory.search-item');
Route::post('inventory/suggestions', 'InventoryController@getInventorySuggestions')->name('inventory.suggestions');
Route::post('inventory/transfer/bystatus', 'InventoryController@fetchTransfersByStatus')->name('inventory.transfer.bystatus');

//inventory-withdraw
Route::post('inventory/withdraw', 'InventoryController@fetchWithdraw')->name('inventory.withdraw.fetch');
Route::post('search-withdrawal', 'InventoryController@searchWithdrawal')->name('search-withdrawal');
Route::post('inventory/withdraw/request', 'InventoryController@requestWithdraw')->name('inventory.withdraw.request');
Route::post('inventory/withdraw/approve/{id}', 'InventoryController@approveWithdraw')->name('inventory.withdraw.approve');
Route::post('inventory/withdraw/decline/{id}', 'InventoryController@declineWithdraw')->name('inventory.withdraw.decline');
Route::post('inventory/withdraw/bystatus', 'InventoryController@fetchWithdrawByStatus')->name('inventory.withdraw.bystatus');

//inventory-categories
Route::get('inventory/categories', 'InventoryController@getCategory')->name('inventory.categories');
Route::get('inventory/subcategories/{id}', 'InventoryController@getSubCategory')->name('inventory.Subcategories');
Route::post('inventory/categories', 'InventoryController@postCategory')->name('inventory.post.categories');
Route::post('inventory/subcategories', 'InventoryController@postSubCategory')->name('inventory.post.subcategories');

//uoms
Route::get('/uom/list', 'InventoryController@getUOMs')->name('uom.list');
Route::get('/uom/settings', 'InventoryController@getUOMSettings')->name('uom.settings');
Route::post('/uom/create', 'InventoryController@postUOM')->name('uom.create');
Route::delete('/uom/{id}', 'InventoryController@deleteUOM')->name('uom.delete');

//inventory-return
Route::post('inventory/return', 'InventoryController@fetchReturns')->name('inventory.return.fetch');
Route::post('inventory/return/request', 'InventoryController@requestReturn')->name('inventory.return.request');
Route::post('search-return', 'InventoryController@searchReturn')->name('search-return');
Route::post('return/suggestions', 'InventoryController@getReturnSuggestions')->name('return.suggestions');
Route::post('return/search', 'InventoryController@returnSearchItem')->name('return.search');
Route::post('inventory/return/approve/{id}', 'InventoryController@approveReturn')->name('inventory.return.approve');
Route::post('inventory/return/decline/{id}', 'InventoryController@declineWithdraw')->name('inventory.return.decline');
Route::post('inventory/return/bystatus', 'InventoryController@fetchReturnsByStatus')->name('inventory.return.bystatus');

//approvers
Route::get('inventory/approvers/{id}', 'InventoryController@getApprovers')->name('inventory.approvers.fetch');

//equipment-list
Route::get('equipment', 'EquipmentController@index')->name('equipment.index');
Route::post('equipment/create', 'EquipmentController@createEquipment')->name('equipment.create');

// Purchase Request
