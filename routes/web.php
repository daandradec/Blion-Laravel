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


Route::get('/admin/login','Web\Admin\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login','Web\Admin\AdminLoginController@login');
Route::get('/admin/register','Web\Admin\AdminRegisterController@showRegistrationForm')->name('admin.register');
Route::post('/admin/register','Web\Admin\AdminRegisterController@register');

Route::get('/user/contents','Web\User\UserController@contents')->name('user.contents');
Route::post('/user/contents/{id}','Web\User\UserController@contentStore')->name('user.contents.store');
Route::delete('/user/contents/{id}','Web\User\UserController@contentDestroy')->name('user.contents.destroy');
Route::get('/user','Web\User\UserController@show')->name('user.show');
Route::match(['put','patch'],'/user/{id}','Web\User\UserController@update')->name('user.update');

/* Temporales */
Route::get('/users','Web\User\UserController@index')->name('user.index');
Route::get('/user/{id}/delete','Web\User\UserController@delete');

use App\User;
use App\SessionToken;
use Carbon\Carbon;
Route::get('/token',function(){
    $user = User::find(1);
    $token = $user->sessionToken;
    $array = $user->toArray();

    var_dump(is_null($token));     

    if(is_null($token)){
        $token = SessionToken::create(['csrf'=>csrf_token(),'expired'=>Carbon::now()->addDays(1)]);
        $user->sessionToken()->save($token);
    }else if(Carbon::now()->gt($token->expired))
        $token->update(['csrf'=>csrf_token(),'expired'=>Carbon::now()->addDays(1)]);
    
    var_dump(Carbon::now()->gt($token->expired));

    $array["auth_token"] = $token->csrf;
    $array["expired_date_token"] = $token->expired["date"];

    dd($array);
    //$token = $user->sessionToken;
    //$token->update(['csrf'=>csrf_token(),'expired'=>Carbon::now()->addDays(1)]);
    //var_dump(Carbon::now()->addDays(1)->toDateTimeString());
    //$user->sessionToken()->save(SessionToken::create(['csrf'=>csrf_token(),'expired'=>Carbon::now()->addDays(1)]));
});

/* APIS */

/** User */
Route::get('/api/users/{id}','Apis\User\UsersControllerApi@index');
Route::get('/api/users/{id}/contents','Apis\User\UsersControllerApi@contents');
Route::get('/api/users/mediacontent/media','Apis\User\UsersControllerApi@mediaContent');
Route::get('/api/users/{id}/image','Apis\User\UsersControllerApi@profilePicture');
Route::post('/api/users/{id}/image','Apis\User\UsersControllerApi@postProfilePicture');

/* Media Contents REST*/
Route::post('api/users/{id}/mediacontent/media','Apis\User\UsersControllerApi@postMediaContent');
Route::post('api/users/{id}/mediacontent/destroy','Apis\User\UsersControllerApi@postDestroyMediaContent');

/** Login */
Route::post('/api/login','Apis\Auth\LoginControllerApi@login');
Route::post('/api/register','Apis\Auth\RegisterControllerApi@register');

/** ********************** **/