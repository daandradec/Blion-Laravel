<?php

namespace App\Http\Controllers\Apis\Auth\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Events\VerifiedEmail;
use App\ProfilePicture;
use App\User;

trait RegisterHandlerTrait{

    private function create(array $data){
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $picture = ProfilePicture::create();
        
        if(config('app.env') != "local"){ /** ENV == production **/
            $picture->profile_picture = 'public/Media/no-avatar.jpg';
            $picture->save();
        }
            
        $user->profilePicture()->save($picture);
        return $user;
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
        $user = $this->create($request->all());
        $this->message = json_encode($this->reduceUserElloquentCollection($user->toArray()));
        event(new VerifiedEmail($user));
        return true;
    }

    private function reduceUserElloquentCollection($array){
        unset($array['created_at']);
        unset($array['updated_at']);
        return $array;
    }
}

?>