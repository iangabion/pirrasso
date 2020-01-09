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

Route::get('/', function () {
    return redirect('dashboard');
});
Route::group(['namespace' => 'Backend'], function()
{
    // pages route
    Route::get('dashboard', 'PagesController@home');
    Route::get('category', 'PagesController@category');
    Route::get('seller', 'PagesController@seller');
    Route::get('view_seller/{id}', 'PagesController@view_seller');

    // ajax route
    Route::post('add_category', 'CategoryController@store');
    Route::get('search_items', 'SearchController@index');

});
