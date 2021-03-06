<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('login/{provider}', 'Auth\\LoginController@redirectToProvider')->name('login.{provider}');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');
Route::resource('/locations', 'LocationController', ['except' => ['index']])->middleware('auth');
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/{name}', 'UserController@show')->name('show');
});
Route::get('/tags/{name}', 'TagController@show')->name('tags.show');
