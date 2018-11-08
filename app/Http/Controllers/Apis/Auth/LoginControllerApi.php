<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Apis\Auth\Traits\LoginValidatorTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginControllerApi extends Controller
{
    use LoginValidatorTrait;

    protected $message;

    public function __construct(){
        $this->message = '';
    }

    public function login(Request $request){                
        $flag = $this->loginRequestValidated($request);
        return response()->json(['success'=>$flag,'message'=>$this->message]);
    }
    
}
