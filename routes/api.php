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
Route::get('inventory', 'InventoryController@index')->name('inventory');
Route::get('subsidiary', 'InventoryController@getSubsidiary')->name('subsidiary');
Route::post('create-inventory', 'InventoryController@createInventory')->name('create-inventory');
Route::patch('update-role/{id}', 'UserController@update')->name('update-role');
Route::get('users', 'UserController@index')->name('users');


