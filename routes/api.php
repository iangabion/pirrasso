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
	Route::get('view_profile' ,'ClientController@show');

	// items part
	Route::post('add_items' ,'ItemsController@store');
	Route::post('add_photos' ,'ItemsController@add_photos');
	Route::post('edit_items' ,'ItemsController@edit');
	Route::get('delete_item/{id}' ,'ItemsController@destroy');
	Route::get('view_item/{id}' ,'ItemsController@show');
	
	
	//send message
	Route::post('send_message' ,'SessionController@store');
	
	// retrieve messages
	Route::get('item_messages/{id}' ,'SessionController@get_item_messages');
	Route::get('user_messages' ,'SessionController@get_user_messages');
	Route::get('user_messages/{id}' ,'SessionController@get_indi_messages');

	// add to favorites
	Route::get('add_favorite/{id}' ,'ClientController@favorites');
	// remove favorites
	Route::get('remove_favorite/{id}' ,'ClientController@remove_favorites');
	//get all favorites
	Route::get('favorites' ,'ClientController@get_favorites');\

	// is sold
	Route::post('is_sold' ,'ItemsController@sold');
	Route::get('unsold/{id}' ,'ItemsController@unsold');
	Route::get('sold_item' ,'ItemsController@getsold_items');
	Route::get('bought_item' ,'ItemsController@getbought_items');
});

// get all items
Route::get('items' ,'ItemsController@index');
// get all categories
Route::get('categories' ,'CategoryController@index');
// get all categories items
Route::get('category_items/{id}' ,'CategoryController@category_items');
// get all status
Route::get('statuses' ,'CategoryController@statuses');





// login and register
Route::post('register' ,'ClientController@store');
Route::post('login' ,'ClientController@login');

// search items
Route::get('search/{item?}' ,'SearchController@index');
