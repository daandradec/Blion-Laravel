<?php

namespace App\Http\Controllers\Apis\User\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\User;

trait ImageUserTrait{

    public function profilePicture($id){      
        return Image::make(Storage::get(User::findOrFail($id)->profilePicturePath()))->response();  
    }
    public function imageSpecific(Request $request){ // mejor retornar una imagen, y desde unity acceder a los paths de la relacion con MediaContents del usuario
        if($request->has('path')){
            return Image::make(Storage::get(urldecode($request->path)))->response();
        }
        return response('error when search image',404);
    }

    public function postProfilePicture(Request $request,$id){                
        $str_img = $request->input('file');
        $str_img = str_replace(@"%2B","+",$str_img);
        $str_img = str_replace(@"%2F","/",$str_img);
        $str_img = str_replace(@"%3D","=",$str_img);
        
        $user = User::findOrFail($id);


        Storage::put('/public/foo.png',base64_decode($str_img));        

        $path = Storage::putFile('public/Users/'.$user->email,new File( public_path(Storage::url('public/foo.png')) ));

        Storage::delete('public/foo.png');

        $picture = $user->profilePicture;
        if(strcmp($picture->profile_picture,"public/Users/no-avatar.jpg"))
            Storage::delete($picture->profile_picture);
        $picture->profile_picture = $path;
        $picture->save();
        

        return response()->json(['sucess' => "enviado"]);    
    }

}
?>