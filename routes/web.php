<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {return view('welcome');});
Route::get('/home',function(){return view('home');})->name('home');

Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@login');
Route::get('/logout','Auth\LoginController@logout')->name('logout');
Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('/register','Auth\RegisterController@register');

Route::get('/admin/login','Web\Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login','Web\Admin\AdminLoginController@login');
Route::get('/admin/register','Web\Admin\AdminRegisterController@showRegistrationForm')->name('admin.register');
Route::post('/admin/register','Web\Admin\AdminRegisterController@register');

Route::get('/user/contents','Web\User\UserController@contents')->name('user.contents');
Route::post('/user/contents/{id}','Web\User\UserController@contentStore')->name('user.contents.store');
Route::delete('/user/contents/{id}','Web\User\UserController@contentDestroy')->name('user.contents.destroy');
Route::get('/user','Web\User\UserController@show')->name('user.show');
Route::match(['put','patch'],'/user/{id}','Web\User\UserController@update')->name('user.update');


/* APIS */

/** User */
Route::get('/api/users/{id}','Apis\User\UsersControllerApi@index');
Route::get('/api/users/{id}/contents','Apis\User\UsersControllerApi@contents');

/* Route::get('/api/users/mediacontent/image','Apis\User\UsersControllerApi@imageSpecific');
Route::get('/api/users/mediacontent/video','Apis\User\UsersControllerApi@videoSpecific');
//Route::post('/api/users/imagenbytes','Apis\User\UsersControllerApi@postProfilePicture2');
 estas 3 remplazadas por solo esta */
Route::get('/api/users/mediacontent/media','Apis\User\UsersControllerApi@mediaContent');

Route::get('/api/users/{id}/image','Apis\User\UsersControllerApi@profilePicture');
Route::post('/api/users/{id}/image','Apis\User\UsersControllerApi@postProfilePicture');


/*
Route::post('/api/users/{id}/mediacontent/image','Apis\User\UsersControllerApi@postImageMediaContent');
Route::post('/api/users/{id}/mediacontent/destroy','Apis\User\UsersControllerApi@postDestroyMediaContent');
Remplazadas por estas */

Route::post('api/users/{id}/mediacontent/media','Apis\User\UsersControllerApi@postMediaContent');
Route::post('api/users/{id}/mediacontent/destroy','Apis\User\UsersControllerApi@postDestroyMediaContent');


/** Login */
Route::post('/api/login','Apis\Auth\LoginControllerApi@login');
Route::post('/api/register','Apis\Auth\RegisterControllerApi@register');

/** ********************** **/