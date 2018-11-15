<?php

namespace App\Http\Controllers\Apis\Auth\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

trait RegisterHandlerTrait{

    private function create(array $data){
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    private function validator(array $data){
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
    private function userAlreadyExists($email){
        return User::where('email','=',$email)->first() != null;
    }

    private function registration($request){
        $validator = $this->validator($request->all());

        if($validator->fails()){
            $this->message = $validator->errors()->first();
            return false;
        }
        $this->create($request->all());
        $this->message = json_encode($this->reduceUserElloquentCollection($user->toArray()));
        return true;
    }

    private function reduceUserElloquentCollection($array){
        unset($array["email_verified_at"]);
        unset($array['created_at']);
        unset($array['updated_at']);
        unset($array['avatar']);
        return $array;
    }
}

?>