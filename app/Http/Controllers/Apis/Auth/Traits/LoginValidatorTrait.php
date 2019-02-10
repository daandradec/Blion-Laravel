<?php

namespace App\Http\Controllers\Apis\Auth\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\SessionToken;
use App\User;

trait LoginValidatorTrait{

    private function loginRequestValidated($request){
        if(!$this->requestValidated($request)){
            $this->message = "The inputs fields are required";
            return false;
        }
        $user = User::where('email', $request->email)->first();
        if(!$this->userExists($user)){
            $this->message = "Wrong Combination";
            return false;
        }
        if(!$this->isRealPassword($request->password,$user->password)){
            $this->message = "Wrong Combination";
            return false;
        }
        
        $this->message = json_encode($this->insertTokenAuth($this->reduceUserElloquentCollection($user->toArray()),$user));
        // si el token no a expirado retornelo
        // si expiro o es nulo genere otro y guardelo

        return true;        
    }

    private function reduceUserElloquentCollection($array){
        unset($array['created_at']);
        unset($array['updated_at']);
        return $array;
    }

    private function insertTokenAuth($array,$user){
        $token = $user->sessionToken;
        if(is_null($token)){
            $token = SessionToken::create(['csrf'=>csrf_token(),'expired'=>Carbon::now()->addDays(1)]);
            $user->sessionToken()->save($token);
        }else if(Carbon::now()->gt($token->expired))
            $token->update(['csrf'=>csrf_token(),'expired'=>Carbon::now()->addDays(1)]);
        
        $array["auth_token"] = $token->csrf;
        $array["expired_date_token"] = $token->expired;
        return $array;
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