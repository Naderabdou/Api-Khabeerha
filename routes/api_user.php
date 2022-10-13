<?php

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


Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/login/email', 'UserAuthController@login_email');
    Route::post('/login/phone', 'UserAuthController@login_phone');
    Route::post('/logout', 'UserAuthController@logout');
    Route::post('register', 'UserAuthController@register');

});


Route::group(['middleware'=>['AuthApi:user_api']],function(){

   Route::post('profile', 'UserController@profile');
   Route::post('profile/update', 'UserController@profile_update');
   Route::post('login/as/serviceProvider', 'UserController@serviceProvider');


   Route::post('user/charging/wallet','UserController@charging_wallet');
   Route::post('user/withdraw/wallet','UserController@withdraw_wallet');


   Route::post('user/scope','UserController@scopes');
   Route::post('user/scope/store','UserController@store_scope');


   Route::post('user/rate/store/{service_provider_id}','UserController@rate_store');
   Route::post('user/rate/update/{service_provider_id}','UserController@rate_update');

   Route::post('user/rate','UserController@rate');






    Route::post('users/order','OrderController@index');
    Route::post('users/order/store','OrderController@store');
    Route::post('users/order/update/{id}','OrderController@update');
    Route::post('users/order/show/{id}','OrderController@show');
    Route::post('users/order/delete/{id}','OrderController@destroy');
    Route::post('my-order','OrderController@order');
    Route::post('request/order/{id}','OrderController@request_order');
    Route::post('accept/order/{id}','OrderController@accpet_order');
    Route::post('cancel/order/{id}','OrderController@cancel_order');
    Route::post('complete/order','OrderController@complete_order');

    Route::post('users/services','OrderController@Services');
    Route::post('users/services/complete','OrderController@Services_complete');

    Route::post('order/favorite/store/{id}','OrderController@favoriteStore');
    Route::post('order/favorite/delete/{id}','OrderController@favoriteDelete');
    Route::post('order/favorite','OrderController@favorite');



    
    


    
    

});