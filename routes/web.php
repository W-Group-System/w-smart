<?php

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
    
    // Settings Routes
    Route::get('/settings/roles', 'RoutesController@settingsRoles')->name('settings.roles');
    Route::get('/settings/category', 'RoutesController@category')->name('category');
    Route::get('/settings/uom', 'RoutesController@uom')->name('settings.uom');
    Route::get('/settings/users', 'RoutesController@userManagement')->name('settings.users');
    Route::get('/settings/company', 'RoutesController@companyManagement')->name('settings.company');

    // Purchased Request
    Route::get('procurement/purchase-request', 'RoutesController@purchaseRequest')->name('procurement.purchase_request');

});
