<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Apis\Auth\Traits\RegisterHandlerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterControllerApi extends Controller
{
    use RegisterHandlerTrait;

    protected $message;

    public function __construct(){
        $this->message = '';
    }

    public function register(Request $request){
        return response()->json(['success'=>$this->registration($request),'message'=>$this->message]);
    }
}
