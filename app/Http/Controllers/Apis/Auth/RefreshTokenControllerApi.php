<?php

namespace App\Http\Controllers\Apis\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefreshTokenControllerApi extends Controller
{
    public function refresh(){
        $token = auth('api')->refresh();
        $expired = auth('api')->factory()->getTTL() * 60;
        return response()->json(['success'=> true,'message'=> ['token' => $token, "expired_date_token" => $expired]],200);
    }
}
