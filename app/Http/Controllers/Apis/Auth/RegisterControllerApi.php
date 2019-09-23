<?php

namespace App\Http\Controllers\Apis\Auth;

use App\Http\Controllers\Apis\Auth\Traits\RegisterHandlerTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterControllerApi extends Controller
{
    use RegisterHandlerTrait;

    protected $message;
    protected $status;

    public function __construct(){
        $this->message = '';
        $this->status = 200;
    }

    public function register(Request $request){
        return response()->json(['success'=>$this->registration($request),'message'=>$this->message], $this->status);
    }
}
