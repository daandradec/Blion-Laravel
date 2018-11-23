<?php

namespace App\Http\Controllers\Apis\Auth\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

trait LoginValidatorTrait{

    private function loginRequestValidated($request){
        if(!$this->requestValidated($request)){
            $this->message = "The inputs fields are required";
            return false;
        }
        $user = User::where('email', $request->email)->first();
        if(!$this->userExists($user)){
            $this->message = "The User doesn't exists";
            return false;
        }
        if(!$this->isRealPassword($request->password,$user->password)){
            $this->message = "The password is incorrect";
            return false;
        }
        $this->message = json_encode($this->reduceUserElloquentCollection($user->toArray()));
        return true;        
    }

    private function reduceUserElloquentCollection($array){
        unset($array["email_verified_at"]);
        unset($array['created_at']);
        unset($array['updated_at']);
        return $array;
    }

    private function requestValidated($request){
        return ! Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ])->fails(); 
    }
    private function userExists($user){
        return $user != null;
    }
    private function isRealPassword($password,$encryptPassword){
        return Hash::check($password,$encryptPassword);
    }
    
}
?>