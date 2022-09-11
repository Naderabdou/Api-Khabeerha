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
    Route::post('/login', 'AdminAuthController@login');
    Route::post('/logout', 'AdminAuthController@logout');

});



Route::group(['middleware'=>['AuthApi:admin_api','UseApi']],function(){
    Route::post('user','userController@index');
    

});
