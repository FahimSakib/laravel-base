<?php

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


Auth::routes(['register'=>false]);

Route::group(['middleware' => ['auth']], function(){
    Route::get('/', 'HomeController@index');

    //menu routes start:
    Route::get('menu','MenuController@index')->name('menu');
    Route::group(['prefix' => 'menu', 'as' => 'menu.'], function(){
        Route::post('datatable-data', 'MenuController@getDatatableData')->name('datatable.data');
        Route::post('store-or-update', 'MenuController@storeOrUpdateData')->name('store.or.update');
        Route::post('edit', 'MenuController@edit')->name('edit');
        Route::post('delete', 'MenuController@delete')->name('delete');
        Route::post('bulk-delete', 'MenuController@bulkDelete')->name('bulk.delete');
        Route::post('order/{menu}','MenuController@orderItem')->name('order');
        
        //Module Routes
        Route::get('builder/{id}','ModuleController@index')->name('builder');
        Route::group(['prefix' => 'module', 'as'=>'module.'], function () {
            Route::get('create/{menu}','ModuleController@create')->name('create');
            Route::post('store-or-update','ModuleController@storeOrUpdate')->name('store.or.update');
            Route::get('{menu}/edit/{module}','ModuleController@edit')->name('edit');
            Route::delete('delete/{module}','ModuleController@destroy')->name('delete');

            Route::get('permission','PermissionController@index')->name('permission');
            Route::group(['prefix' => 'permission', 'as' => 'permission.'], function(){
                Route::post('datatable-data', 'PermissionController@getDatatableData')->name('datatable.data');
                Route::post('store-or-update', 'PermissionController@store')->name('store');
                Route::post('edit', 'PermissionController@edit')->name('edit');
                Route::post('update', 'PermissionController@update')->name('update');
                Route::post('delete', 'PermissionController@delete')->name('delete');
                Route::post('bulk-delete', 'PermissionController@bulkDelete')->name('bulk.delete');
            });
        });
    });

    Route::get('role', 'RoleController@index')->name('role');
    Route::group(['prefix' => 'role', 'as'=>'role.'], function () {
        Route::get('create', 'RoleController@create')->name('create');
        Route::post('datatable-data', 'RoleController@getDatatableData')->name('datatable.data');
        Route::post('store-or-update', 'RoleController@storeOrUpdate')->name('store.or.update');
        Route::get('edit/{id}', 'RoleController@edit')->name('edit');
        Route::get('view/{id}', 'RoleController@show')->name('view');
        Route::post('delete', 'RoleController@delete')->name('delete');
        Route::post('bulk-delete', 'RoleController@bulkDelete')->name('bulk.delete');
    });

});
