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
        });
    });

});
