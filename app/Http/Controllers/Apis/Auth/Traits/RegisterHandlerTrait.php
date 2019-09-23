<?php

namespace App\Http\Controllers\Apis\Auth\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Repositories\ApiHelpers;
use App\Events\VerifiedEmail;
use App\ProfilePicture;
use App\User;

trait RegisterHandlerTrait{

    use ApiHelpers;

    /* METODO PARA REALIZAR EL REGISTRO DEL USUARIO VALIDANDO Y CREANDO AL USUARIO */
    private function registration($request){
        $validator = $this->validator($request->all());

        if($validator->fails()){            
            $this->responseStatusMessage($validator->errors()->first(), 404);     
            return false;
        }

        $user = $this->create($request->all());
        $this->prepareResponse($request, $user);
        event(new VerifiedEmail($user));
        
        return true;
    }

    /* METODO PARA GUARDAR EL USUARIO Y PREPARAR LA RESPUESTA */
    private function prepareResponse($request, $user){        
        $token = auth('api')->attempt(request(['email', 'password']));
        $expired = auth('api')->factory()->getTTL() * 60;        
        $this->responseStatusMessage(json_encode( $this->appendFields($this->reduceElloquentCollection($user->toArray()),["token","expired_date_token"],[$token,$expired])), 200);
    }

    /* METODO PARA CREAR AL USUARIO JUNTO CON SU IMAGEN DE PERFIL */
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

    /* VALIDADOR DEL USUARIO */
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
}

?>