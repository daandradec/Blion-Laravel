<?php

namespace App\Http\Controllers\Apis\User;

use App\Http\Controllers\Apis\User\Traits\ImageUserTrait;
use App\Http\Controllers\Apis\User\Traits\MediaContentTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UsersControllerApi extends Controller
{
    use MediaContentTrait;

    public function index($id){  // creo que no lo estoy utilizando, comprobarlo despues borrandolo
        $user = User::find($id);
        if($user == null)
            return response()->json(['success' => false,'name' => '','email' => '']);
        return response()->json(['success' => true,'message'=>json_encode($user->toArray())]);
    }

    public function contents($id){

        /********* Comprobacion para Incrementar la seguridad *********/
        $user = User::find($id);
        if($user == null)
            return response()->json(['success' => false, 'message' => "Error getting the contents of your user"]);
        //if( $user->sessionToken->csrf !== $token ) // || $user->sessionToken->hasExpired()
        //    return response()->json(['success'=>false,'message'=> "Your session id has expired, please sign in again"]);
         /* ********************* */
         
            
        $paths = $user->mediaContents()->select('media_path')->get()->toArray();
        $list = [];
        for($i=0; $i < sizeof($paths);++$i){
            $list[$i] = urlencode($paths[$i]['media_path']);
        }
        return response()->json(['success' => true,'message'=> $list]); //json_encode($user->mediaContents()->select('media_path')->get())
    }
}
