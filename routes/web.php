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
    return view('welcome');
});
// Route::group(['namespace' => 'Backend'], function()
// {
//     // pages route
//     Route::get('dashboard', 'PagesController@home');
//     Route::get('category', 'PagesController@category');
//     Route::get('seller', 'PagesController@seller');
//     Route::get('view_seller/{id}', 'PagesController@view_seller');

//     // ajax route
//     Route::post('add_category', 'CategoryController@store');
//     Route::get('search_items', 'SearchController@index');

// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function () {
    return redirect('/login');
});
Route::middleware('auth:web')->group(function () {
    Route::namespace('Backend')->group(function () {
        Route::resource('client' , 'ClientController');
        Route::resource('clients' , 'ClientController');
        Route::resource('item' , 'ItemController');
        Route::resource('status', 'StatusController');

        Route::get('category_items/{id}' , 'CategoryController@get_items');
        Route::resource('category', 'CategoryController');
        Route::resource('subcategories', 'SubCategoryController');

        Route::get('/logout' , 'ClientController@out');

        // sold
        Route::get('sold_count' , 'ItemController@sold_count');
        // always at last
        Route::get('/{path}', 'PagesController@index')->where( 'path', "([A-z\d\-/_.]+)?" );
    });
});
