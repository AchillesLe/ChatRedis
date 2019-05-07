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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'Auth\LoginController@do_login');

Route::middleware([ 'api_token' ])->group(function () {
    Route::get('logout', 'Auth\LoginController@api_logout');
    Route::get('rooms', 'RoomController@getAllRoom');
});
