<?php
use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::group( ['middleware' => ['auth'] ] , function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/chatroom', 'MessageController@room');
    Route::get('/chat/{id}', 'MessageController@index');
    Route::get('/getUserLogin', 'MessageController@getuserlogin' );
    Route::get('/messages/{id}', 'MessageController@getMessage' );
    Route::post('/messages', 'MessageController@postMessage' );
    // Room
    Route::get('/allroom', 'RoomController@getAllRoom');
    Route::get('/myroom', 'RoomController@getMyRoom');
    Route::post('/create-room', 'RoomController@create');
}); 