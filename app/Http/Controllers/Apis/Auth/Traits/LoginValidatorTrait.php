<?php

namespace App\Http\Controllers\Apis\Auth\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ApiHelpers;
use Carbon\Carbon;
use App\SessionToken;
use App\User;

trait LoginValidatorTrait{

    use ApiHelpers;

    private function loginRequestValidated($request){
        if(!$this->requestValidated($request)){
            $this->responseStatusMessage("The inputs fields are required", 404);            
            return false;
        }
        
        $user = User::where('email', $request->email)->first();
        if(!$this->userExists($user)){
            $this->responseStatusMessage("Wrong Combination", 404);
            return false;
        }

        if(!$this->isRealPassword($request->password,$user->password)){
            $this->responseStatusMessage("Wrong Combination", 404);            
            return false;
        }

        $token = auth('api')->attempt(request(['email', 'password']));
        $expired = auth('api')->factory()->getTTL() * 60;
                  
        $this->responseStatusMessage(json_encode( $this->appendFields($this->reduceElloquentCollection($user->toArray()),["token","expired_date_token"],[$token,$expired])), 200);
        
        return true;        
    }

    private function requestValidated($request){
        return ! Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ])->fails(); //true or false
    }
    private function userExists($user){
        return !is_null($user);
    }
    private function isRealPassword($password,$encryptPassword){
        return Hash::check($password,$encryptPassword);
    }
    
}
?>