<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {return view('welcome');});
Route::get('/home',function(){return view('home');})->name('home')->middleware('verified');

Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@login');
Route::get('/logout','Auth\LoginController@logout')->name('logout');
Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register','Auth\RegisterController@register');


Route::get('/email/resend','Auth\VerificationController@resend')->name('verification.resend'); // la uri para reenviar un email desde la vista
Route::get('/email/verify','Auth\VerificationController@show')->name('verification.notice'); // vista para no acceder sin verificar email
Route::get('/email/verify/{id}','Auth\VerificationController@verify')->name('verification.verify'); // la uri que usa el email para verificar



Route::get('/user/contents','Web\User\UserController@contents')->name('user.contents');
Route::post('/user/contents/{id}','Web\User\UserController@contentStore')->name('user.contents.store');
Route::delete('/user/contents/{id}','Web\User\UserController@contentDestroy')->name('user.contents.destroy');
Route::get('/user','Web\User\UserController@show')->name('user.show');
Route::match(['put','patch'],'/user/{id}','Web\User\UserController@update')->name('user.update');

/* Temporales */
Route::get('/users','Web\User\UserController@index')->name('user.index');
Route::get('/user/{id}/delete','Web\User\UserController@delete');
