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

Route::middleware("auth.jwt")->group(function(){
    /** USER */
    Route::get('users/{id}/contents','Apis\User\UsersControllerApi@contents');
    /* PROFILE PICTURE */
    Route::post('users/{id}/image','Apis\User\UsersControllerApi@postProfilePicture');
    /* Media Contents REST*/
    Route::post('users/{id}/mediacontent/media','Apis\User\UsersControllerApi@postMediaContent');
    Route::post('users/{id}/mediacontent/destroy','Apis\User\UsersControllerApi@postDestroyMediaContent');
    /* LOGIN */
    Route::post('logout', 'Apis\Auth\LogoutControllerApi@logout');
});


/** USER */
Route::get('users/{id}','Apis\User\UsersControllerApi@index');

/* PROFILE PICTURE */
Route::get('users/{id}/image','Apis\User\UsersControllerApi@profilePicture');

/* Media Contents REST*/
Route::get('users/{id}/mediacontent/media','Apis\User\UsersControllerApi@mediaContent');


/** Login */
Route::post('login', 'Apis\Auth\LoginControllerApi@login');
Route::post('register', 'Apis\Auth\RegisterControllerApi@register');
Route::post('token/refresh', 'Apis\Auth\RefreshTokenControllerApi@refresh');

/** ********************** **/
