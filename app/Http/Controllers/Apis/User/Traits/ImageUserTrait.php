<?php

namespace App\Http\Controllers\Apis\User\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\User;

trait ImageUserTrait{

    public function profilePicture($id){ 
        if(config('app.env') == "local")
            return Image::make(Storage::get(User::findOrFail($id)->profilePicturePath()))->response();         
        /** ENV == production **/
        return response()->file( storage_path('app/' . User::findOrFail($id)->profilePicturePath()) );  
        //return response()->file(public_path(User::findOrFail($id)->profilePicturePath())); ---- mientras no tengamos aws s3
    }


    public function imageSpecific(Request $request){ // mejor retornar una imagen, y desde unity acceder a los paths de la relacion con MediaContents del usuario
        if($request->has('path')){
            if(config('app.env') == "local")
                return Image::make(Storage::get(urldecode($request->path)))->response();
            /** ENV == production **/
            return response()->file(public_path(urldecode($request->path)));
        }
        return response('error when search image',404);
    }

    public function postProfilePicture(Request $request,$id){                
        $str_img = $request->input('file');
        $str_img = str_replace(@"%2B","+",$str_img);
        $str_img = str_replace(@"%2F","/",$str_img);
        $str_img = str_replace(@"%3D","=",$str_img);
        
        $user = User::findOrFail($id);

        if(config('app.env') == "local"){
            Storage::put('/public/foo.png',base64_decode($str_img));        

            $path = Storage::putFile('public/Users/'.$user->email,new File( public_path(Storage::url('public/foo.png')) ));

            Storage::delete('public/foo.png');

            $picture = $user->profilePicture;
            if(strcmp($picture->profile_picture,"public/Users/no-avatar.jpg"))
                Storage::delete($picture->profile_picture);
            $picture->profile_picture = $path;
            $picture->save();
        }
        /** ENV == production **/
        if(config('app.env') == "production")
            return response()->json(['sucess' => "En produccion instala AWS S3"]);

        return response()->json(['success' => "enviado"]);    
    }

    public function postImageMediaContent(Request $request,$id){
        $str_img = $request->input('file');
        $str_img = str_replace(@"%2B","+",$str_img);
        $str_img = str_replace(@"%2F","/",$str_img);
        $str_img = str_replace(@"%3D","=",$str_img);
        
        $user = User::findOrFail($id);

        if(config('app.env') == "local"){
            Storage::put('/public/foo.png',base64_decode($str_img));        

            $path = Storage::putFile('public/Users/'.$user->email,new File( public_path(Storage::url('public/foo.png')) ));

            Storage::delete('public/foo.png');

            $user->mediaContents()->create(['media_path'=> $path, 'media_type'=>'image']);
        }

        if(config('app.env') == "production")
            return response()->json(['sucess' => "En produccion instala AWS S3"]);
        
        return response()->json(['success' => true,'message' => urlencode($path)]);   
    }

    public function postDestroyMediaContent(Request $request, $id){
        $user = User::findOrFail($id);
        if(config('app.env') == "local"){
            $path = urldecode($request->input('file'));
            
            Storage::delete($path);
            $mediaContent = $user->mediaContents->where('media_path',$path)->first();
            $mediaContent->delete();

        }

        if(config('app.env') == "production")
            return response()->json(['sucess' => "En produccion instala AWS S3"]);

        return response()->json(['success' => "destruido"]);
    }
}
?>