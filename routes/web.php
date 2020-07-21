<?php

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
Auth::routes();
    
Route::group(['middleware' => ['auth']], function() {
        Route::get('waiting', 'HomeController@waiting')->name('waiting');
        Route::get('error', 'HomeController@error')->name('error');
        Route::middleware(['approved'])->group(function () {
            Route::resource('post', 'PostController');
            Route::get('donation/{id}/delivered','DeliveryController@collect');
            Route::get('delivery/past', 'DeliveryController@show_past_food_pickup');
            Route::get('delivery/upcoming', 'DeliveryController@show_upcoming_food_pickup');
            Route::resource('delivery', 'DeliveryController');
            Route::get('bundle/{id}/collected','BundleController@collect');
            Route::resource('bundle', 'BundleController');
        });
    
    Route::get('users/profile','UserController@showProfile');
    Route::post('users/profile','UserController@saveProfile');
    Route::group(['middleware'=> ['role:Admin']], function(){
        Route::get('/dashboard','DonationController@chartSample1')->name('dashboard');
        Route::get('users/{id}/approve','UserController@approve');
        Route::resource('users','UserController');
        });

    Route::resource('roles','RoleController');

    Route::get('document/{id}/open','DocumentController@getFile');
    Route::resource('document', 'DocumentController');

Route::get('money', 'StripePaymentController@index');
Route::get('money/create', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');

Route::resource('donation', 'DonationController');

Route::resource('foodItem', 'ItemController');



Route::resource('reward', 'RewardPointController');







Route::prefix('status')->group(function () {
    Route::get('/', 'OtherController@showAllStatus')->name('status.index');
    Route::get('create/', 'OtherController@createStatus');
    Route::post('create/', 'OtherController@storeStatus');
    Route::get('edit/{id}', 'OtherController@editStatus');
    Route::post('edit/', 'OtherController@updateStatus');
    Route::get('/{id}', 'OtherController@showStatus');
    Route::get('delete/{id}', 'OtherController@destroyStatus');
});

Route::prefix('category')->group(function () {
    Route::get('/', 'OtherController@showAllCategory')->name('category.index');
    Route::get('create/', 'OtherController@createCategory');
    Route::post('create/', 'OtherController@storeCategory');
    Route::get('edit/{id}/', 'OtherController@editCategory');
    Route::post('edit/', 'OtherController@updateCategory')->name('edit');
    Route::get('/{id}', 'OtherController@showCategory');
    Route::get('delete/{id}', 'OtherController@destroyCategory');
});

Route::get('/', function () {
    if(Auth::user()->roles->pluck( 'name' )->contains( 'Admin' ))
    {
        return redirect()->route('dashboard');
    }
    else if(Auth::user()->roles->pluck( 'name' )->contains( 'Student' ))
    {
        return redirect()->route('bundle.index');
    }
    else if(Auth::user()->roles->pluck( 'name' )->contains( 'Volunteer' ))
    {
        return redirect()->route('delivery.index');
    } else if(Auth::user()->roles->pluck( 'name' )->contains( 'Donor' ))
    {
        return redirect()->route('donation.index');
    }
    // } else {
    //     return redirect()->route('login');
    // }
});

});
Route::get('welcome', 'PostController@welcome')->name('welcome');

Route::get('register1', 'UserController@register1')->name('users.register1');
Route::post('register1', 'UserController@save')->name('users.save');




