<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('sendMessage', 'SMSController@sendMessage');

Route::get('/privacy-policy', function () {
    return view('privacy');
});
Route::get('/terms&condition', function () {
    return view('terms&condition');
});
Route::middleware('auth:web')->group(function () {
    Route::namespace('Backend')->group(function () {

        Route::resource('status', 'StatusController');

        Route::get('category_items/{id}' , 'CategoryController@get_items');


        Route::get('/logout' , 'ClientController@out');

        Route::get('getweekly' ,'ItemController@getweekly');
        // Route::get('expirationDate', 'ItemController@expirationDate');
        Route::get('getdaily', 'ItemController@getdaily');
        Route::get('items/getToApprovedItems', 'ItemController@getToApprovedItems');
        Route::delete('items/disapproved/{id}','ItemController@deleteApprovedItem');
        Route::get('items/approve_item/{id}', 'ItemController@approvedItem');
        Route::put('activate', 'ItemController@activate');
        Route::put('deactivate', 'ItemController@deactivate');
        // sold
        Route::get('sold_count' , 'ItemController@sold_count');

        //smtp crud
        Route::post('smtp/search', 'SmtpSettingController@search');
        Route::post('smtp/create', 'SmtpSettingController@store');
        Route::delete('smtp/delete/{id}', 'SmtpSettingController@destroy');
        Route::get('smtp/show/{id}','SmtpSettingController@show');
        Route::put('smtp/update/{id}','SmtpSettingController@update');
        Route::get('smtp/set_default/{id}', 'SmtpSettingController@setDefault');

        Route::post('approved_items/disapprovement', 'EmailNoticeController@disapprovementEmail')->name('disapprovement');
        Route::post('approved_items/approve', 'EmailNoticeController@approveEmail')->name('approve');
        
        Route::get('indexPromotion','PromotionController@index');
        //dashboard
        Route::get('stock_count', 'ItemController@stock_count');
        Route::post('month_item','ItemController@getMonthlyItem');

        Route::post('client/search', 'ClientController@searchClient');

        Route::get('showClient/pagination','ClientController@showClient');
        Route::resource('client' , 'ClientController');
        Route::resource('clients' , 'ClientController');
        Route::resource('item' , 'ItemController');
        Route::resource('category', 'CategoryController');
        Route::resource('subcategories', 'SubCategoryController');

        // always at last
        Route::get('/{path}', 'PagesController@index')->where( 'path', "([A-z\d\-/_.]+)?" );

        Route::put('approve/{id}','PromotionController@approve');
        Route::delete('remove/{id}','PromotionController@remove');
       

    });
});
