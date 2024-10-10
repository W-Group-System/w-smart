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

Route::get('permissions', 'PermissionController@index')->name('permissions');
Route::get('features', 'PermissionController@getFeatures')->name('features');
Route::get('roles', 'PermissionController@getRoles')->name('roles');
Route::post('create-role', 'PermissionController@createRole')->name('create-role');
Route::post('create-permission', 'PermissionController@createPermission')->name('create-permission');
Route::post('inventory', 'InventoryController@index')->name('inventory');
Route::get('subsidiary', 'InventoryController@getSubsidiary')->name('subsidiary');
Route::post('create-inventory', 'InventoryController@createInventory')->name('create-inventory');
Route::patch('update-role/{id}', 'UserController@update')->name('update-role');
Route::get('users', 'UserController@index')->name('users');
Route::post('delete-role', 'PermissionController@delete')->name('delete-role');
Route::post('search-inventory', 'InventoryController@search')->name('search-inventory');
Route::post('inventory/transfer/request', 'InventoryController@requestTransfer')->name('inventory.transfer.request');
Route::post('inventory/transfer/approve/{transferId}', 'InventoryController@approveTransfer')->name('inventory.transfer.approve');
Route::post('inventory/transfer', 'InventoryController@fetchTransfers')->name('inventory.transfer.fetch');
Route::get('inventory/search-item', 'InventoryController@searchItem')->name('inventory.search-item');
Route::post('inventory/suggestions', 'InventoryController@getInventorySuggestions')->name('inventory.suggestions');
Route::post('inventory/withdraw', 'InventoryController@fetchWithdraw')->name('inventory.withdraw.fetch');
Route::post('inventory/withdraw/request', 'InventoryController@requestWithdraw')->name('inventory.withdraw.request');