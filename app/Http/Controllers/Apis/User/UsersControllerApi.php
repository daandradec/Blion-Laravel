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

    public function index($id){
        $user = User::find($id);
        if($user == null)
            return response()->json(['success' => false,'name' => '','email' => '']);
        return response()->json(['success' => true,'message'=>json_encode($user->toArray())]);
    }

    public function contents($id){
        $user = User::find($id);
        if($user == null)
            return response()->json(['success' => false]);

        $paths = $user->mediaContents()->select('media_path')->get()->toArray();
        $list = [];
        for($i=0; $i < sizeof($paths);++$i){
            $list[$i] = urlencode($paths[$i]['media_path']);
        }
        return response()->json(['success' => true,'message'=> $list]); //json_encode($user->mediaContents()->select('media_path')->get())
    }


    public function csrf(){
        return response()->json(['csrf' => csrf_token()]);
    }
}
