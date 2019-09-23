<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Apis\Auth\Traits\LoginValidatorTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginControllerApi extends Controller
{
    use LoginValidatorTrait;

    protected $message;
    protected $status;

    public function __construct(){
        $this->message = '';
        $this->status = 200;
    }

    public function login(Request $request){
        $flag = $this->loginRequestValidated($request);
        return response()->json(['success'=>$flag,'message'=>$this->message], $this->status);
    }
    
}
