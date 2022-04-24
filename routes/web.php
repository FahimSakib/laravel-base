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
    });
    //menu routes end

});
