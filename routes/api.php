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

// User API
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::middleware('auth:api')->get('user', 'UserController@index');
Route::middleware('auth:api')->get('logout', 'UserController@logout');

// 串接 Ubike API
Route::get('UbikeSearch', 'UbikeApiController@search_sna');