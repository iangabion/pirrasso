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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->group(function () {
	// clients part
	Route::get('clients' ,'ClientController@index');
	Route::post('update_profile' ,'ClientController@update_profile');
	Route::get('view_client/{id}' ,'ClientController@show');

	// items part
	Route::post('add_items' ,'ItemsController@store');
	Route::get('view_item/{id}' ,'ItemsController@show');
});

// get all items
Route::get('items' ,'ItemsController@index');
// get all categories
Route::get('categories' ,'CategoryController@index');


// login and register
Route::post('register' ,'ClientController@store');
Route::post('login' ,'ClientController@login');

// search items
Route::get('search/{item?}' ,'SearchController@index');
