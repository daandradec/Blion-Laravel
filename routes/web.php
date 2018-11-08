<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {return view('welcome');});
Route::get('/home',function(){return view('home');});

Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@login');
Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register','Auth\RegisterController@register');

Route::get('/admin/login','Web\Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login','Web\Admin\AdminLoginController@login');
Route::get('/admin/register','Web\Admin\AdminRegisterController@showRegistrationForm')->name('admin.register');
Route::post('/admin/register','Web\Admin\AdminRegisterController@register');

