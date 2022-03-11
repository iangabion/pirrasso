<?php

use App\Http\Controllers\SMSController;
use App\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

	Route::post('logout' ,'ClientController@logout');
	// clients part
	Route::get('clients' ,'ClientController@index');
	Route::get('view_profile' ,'ClientController@show');
	Route::post('update_profile' ,'ClientController@update_profile');
	// items part
	Route::post('add_items' ,'ItemsController@store');
	Route::post('add_photos' ,'ItemsController@add_photos');
	Route::post('edit_items' ,'ItemsController@edit');
	Route::get('delete_item/{id}' ,'ItemsController@destroy');
	Route::get('view_item/{id}' ,'ItemsController@show');

//


	//send message
	Route::post('send_message' ,'SessionController@store');
    Route::get('messages/read/{id}' ,'MessageController@readMessage');
	Route::delete('delete_message/{id}','MessageController@deleteMessage');

	// retrieve messages
	Route::get('user_messages' ,'SessionController@get_user_messages');
	Route::get('user_messages/{id}' ,'SessionController@get_indi_messages');
	Route::get('count_messages/{id}' ,'SessionController@count_item_messages');

	// reviews
	Route::post('add_review','ProductReviewController@store');
	Route::get('unreadReview','ProductReviewController@getUnread');
	Route::put('readReview/{id}','ProductReviewController@updateRead');

	// add to favorites
	Route::get('add_favorite/{id}' ,'ClientController@favorites');
	// remove favorites
	Route::get('remove_favorite/{id}' ,'ClientController@remove_favorites');
	//get all favorites
	Route::get('favorites' ,'ClientController@get_favorites');

	// is sold
	Route::post('is_sold' ,'ItemsController@sold');
	Route::get('unsold/{id}' ,'ItemsController@unsold');
	Route::get('sold_item' ,'ItemsController@getsold_items');
    Route::get('bought_item' ,'ItemsController@getbought_items');

    Route::post('change_status' ,'ItemsController@changeStatus');

	
	//add drafts
	Route::get('getDrafts','ItemsController@getDrafts');
	Route::post('editDraft/{id}','ItemsController@editDraft');
	Route::delete('deleteDraft/{id}','ItemsController@deleteDrafts');
	Route::post('save_draft','ItemsController@storeDraft');
	
	

	Route::get('count', 'MessageController@count');


	// Route::get('item_messages2' ,'SessionController@get_item_messages2');



	
});

Route::get('item_messages/{id}' ,'SessionController@get_item_messages');


//global search
Route::post('search', 'ItemController@search');
Route::post('global_search_item','SearchController@global_search_item');
Route::post('global_search_client','SearchController@global_search_client');
Route::post('global_search', 'SearchController@global_search');


// get all items
Route::get('items' ,'ItemsController@index');
Route::get('all_items' , 'ItemsController@all_items');

// add subcat icons
Route::post('add_subcat_icon' ,'CategoryController@add_subcat_icon');
// get all categories
Route::get('categories' ,'CategoryController@index');
// get all categories items
Route::get('category_items/{id}' ,'CategoryController@category_items');
Route::get('get_items/{id}' ,'CategoryController@get_items');
Route::get('get_all_items' ,'CategoryController@get_all');
Route::get('get_all_items_unapproved' ,'CategoryController@get_all_unapproved');
Route::post('get_category/{id}','CategoryController@get_category');



// get all status
Route::get('statuses' ,'CategoryController@statuses');
Route::post('update_catPos', 'CategoryController@update_catPos');
Route::post('update_subCatPos', 'CategoryController@update_subCatPos');
// Route::post('getSubCat/{id}', 'CategoryController@getSubCat');
Route::get('getAll', 'CategoryController@getAll');




// login and register
Route::post('register' ,'ClientController@store');
Route::post('register_mobile' ,'ClientController@register_mobile');
Route::post('login' ,'ClientController@login');
Route::post('loginfacebook' ,'ClientController@facebookLogin');
Route::post('loginapple' ,'ClientController@appleLogin');
Route::post('verify_code' ,'ClientController@checkVerificationCode');
Route::post('resend_code' ,'ClientController@resendVerificationCode');
Route::post('forgot-password/send-email' ,'ForgotPasswordController@checkEmail');
Route::post('reset-password' ,'ForgotPasswordController@checkToken');
Route::get('test_code' ,'ClientController@sendVerificationCode');





// search items
Route::post('searchchan' ,'SearchController@searchchan');
Route::post('searchchan2' ,'SearchController@searchchan2');
Route::get('search/{item?}' ,'SearchController@index');

//API Settings Apps Images
Route::get('get_catgry_image','CategoryController@get_catgry_image');
Route::get('get_sub_image','CategoryController@get_sub_image');
Route::get('get_allPhoto', 'PhotosController@get_allPhoto');
Route::post('add_photo4Logo', 'PhotosController@add_photo4Logo');

//Sms api
Route::get('get_admin', 'SmsController@get_admin'); 
Route::post('sms_sender', 'SMSController@sms_sender');
Route::put('change_number', 'ClientController@change_number');
Route::post('send_sms_test', 'SMSController@send_sms_test');
Route::post('enable_disable', 'SMSController@enable_disable');




// Route::get('sendMessage', 'SMSController@sendMessage');


Route::post('add_rating','ProductReviewController@store');
Route::put('update_review/{id}','ProductReviewController@update_review');
Route::delete('delete_review/{id}','ProductReviewController@destroy');
Route::get('getStarRating', 'ItemsController@getStarRating');

//add drafts

// Route::post('editDrafts','ItemsController@editDrafts');
// Route::delete('deleteDraft/{id}','ItemsController@deleteDrafts');


//promotions

Route::get('indexPromotion','PromotionController@index');
Route::get('fetchAllPromo','PromotionController@fetchAll');
Route::post('save_promotion','PromotionController@store');
Route::post('edit_promotion/{id}','PromotionController@update');
Route::delete('delete_promotion/{id}','PromotionController@destroy');

Route::delete('delete_photo/{id}','PhotosController@delete_photo');












