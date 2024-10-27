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

// Route::get('attendance','AttendanceController@create')->name('create-attendance');
Route::get('payslip-api/{empid}/{id}', 'PayrollController@payslipAPI')->name('payslip-api');
Route::get('sss-api/', 'PayrollController@sss_get')->name('sss-api');
Route::get('sss-update/', 'PayrollController@sss_update')->name('sss-update');
Route::post('api/sss-post', 'PayrollController@sss_post')->name('sss-post');

Auth::routes();
Route::post('rates', 'PayrollController@getRatesStore')->name('store-rates');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/inventory/list', 'RoutesController@inventoryList')->name('inventory.list');
    Route::get('/inventory/transfer', 'RoutesController@inventoryTransfer')->name('inventory.transfer');
    Route::get('/inventory/withdrawal', 'RoutesController@inventoryWithdrawal')->name('inventory.withdrawal');
    Route::get('/inventory/returned', 'RoutesController@inventoryReturned')->name('inventory.returned');
    Route::get('/settings/roles', 'RoutesController@settingsRoles')->name('settings.roles');
    Route::get('/settings/category', 'RoutesController@category')->name('category');
    Route::get('/settings/uom', 'RoutesController@uom')->name('settings.uom');
});
