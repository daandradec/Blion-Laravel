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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});




/* APIS */

/** USER */
Route::get('users/{id}','Apis\User\UsersControllerApi@index');
Route::get('users/{id}/contents','Apis\User\UsersControllerApi@contents');

/* PROFILE PICTURE */
Route::get('users/{id}/image','Apis\User\UsersControllerApi@profilePicture');
Route::post('users/{id}/image','Apis\User\UsersControllerApi@postProfilePicture');

/* Media Contents REST*/
Route::get('users/{id}/mediacontent/media','Apis\User\UsersControllerApi@mediaContent');
Route::post('users/{id}/mediacontent/media','Apis\User\UsersControllerApi@postMediaContent');
Route::post('users/{id}/mediacontent/destroy','Apis\User\UsersControllerApi@postDestroyMediaContent');

/** Login */
Route::post('login','Apis\Auth\LoginControllerApi@login');
Route::post('register','Apis\Auth\RegisterControllerApi@register');

/** ********************** **/
