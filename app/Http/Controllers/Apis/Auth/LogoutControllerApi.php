<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutControllerApi extends Controller{

    public function logout(){
        auth('api')->logout();
        return response()->json(['success'=> true,'message'=> 'success logout'],200);
    }
}