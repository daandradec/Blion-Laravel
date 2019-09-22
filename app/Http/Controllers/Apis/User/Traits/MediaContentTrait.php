<?php

namespace App\Http\Controllers\Apis\User\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\File;
use App\User;

trait MediaContentTrait{

    public function profilePicture($id){ // GET

        /********* Comprobacion para Incrementar la seguridad *********/ // para ver si se puede llevar a un metodo tocaria ver si se puede ejecutar una funcion antes que cualquier metodo de aqui
        $user = User::findOrFail($id);         
        //if( $user->sessionToken->csrf !== $token ) // || $user->sessionToken->hasExpired()
        //    return response("Your session id has expired, please sign in again", 404);            
        /* ********************* */


        if(config('app.env') == "local")
            return Storage::response($user->profilePicturePath());
        /** ENV == production **/
        return Storage::disk('s3')->response($user->profilePicturePath());

    }

    public function postProfilePicture(Request $request, $id){ // POST
        
        /********* Comprobacion para Incrementar la seguridad *********/
        $user = User::findOrFail($id);         
        //if( $user->sessionToken->csrf !== $token )  // || $user->sessionToken->hasExpired()
        //    return response("Your session id has expired, please sign in again", 404);            
        /* ********************* */


        if($request->hasFile('mediafile')){
            $picture = $user->profilePicture;
            if(config('app.env') == "local"){                
                if(strcmp($picture->profile_picture,"public/Users/no-avatar.jpg"))
                    Storage::delete($picture->profile_picture);
                $picture->profile_picture = $request->file('mediafile')->store('public/Users/'.$user->email);
            }else{      /** ENV == production **/
                if(strcmp($picture->profile_picture,"public/Media/no-avatar.jpg"))
                    Storage::disk('s3')->delete($picture->profile_picture);
                $picture->profile_picture = Storage::disk('s3')->putFile('public/Media/'.$user->email, $request->file('mediafile'),"public"); 
            }
            $picture->save();
            return response()->json(['sucess' => "enviado"]);            
        }
            
        return response('error sending the data to the server', 404); 
    }

    public function mediaContent(Request $request,$id){ // GET
        
        /********* Comprobacion para Incrementar la seguridad *********/
        $user = User::findOrFail($id);         
        //if( $user->sessionToken->csrf !== $token ) // || $user->sessionToken->hasExpired()
        //    return response("Your session id has expired, please sign in again", 404);            
        /* ********************* */


        if($request->has('path')){
            $path = urldecode($request->path);
            if(config('app.env') == "local")            
                return Storage::response($path);
            /** ENV == production **/
            return Storage::disk('s3')->response($path);
        }

        return response('error sending the data to the server', 404); 
    }

    public function postMediaContent(Request $request, $id){ // POST

        /********* Comprobacion para Incrementar la seguridad *********/
        $user = User::findOrFail($id);         
        //if( $user->sessionToken->csrf !== $token ) // || $user->sessionToken->hasExpired()
        //    return response("Your session id has expired, please sign in again", 404);            
        /* ********************* */

        if($request->hasFile('mediafile')){
            $type = $request->file('mediafile')->getMimeType();
            $type = substr($type, 0, strpos($type, "/"));

            if(config('app.env') == "local"){  
                $path = $request->file('mediafile')->store('public/Users/'.$user->email);
                if($type == "image")
                    $user->mediaContents()->create(['media_path'=> $path, 'media_type'=>'image']);
                if($type == "video")
                    $user->mediaContents()->create(['media_path'=> $path,'media_type'=>'video']);

                return response()->json(['success' => true,'message' => urlencode($path)]);
            }else{      /** ENV == production **/
                $path = Storage::disk('s3')->putFile('public/Media/'.$user->email, $request->file('mediafile'),"public");
                if($type == "image")
                    $user->mediaContents()->create(['media_path'=> $path, 'media_type'=>'image']);
                if($type == "video")
                    $user->mediaContents()->create(['media_path'=> $path,'media_type'=>'video']);                
            }
            return response()->json(['success' => true,'message' => urlencode($path)]);  
        }
            
        return response('error sending the data to the server', 404); 
    }

    public function postDestroyMediaContent(Request $request, $id){

        /********* Comprobacion para Incrementar la seguridad *********/
        $user = User::findOrFail($id);         
        //if( $user->sessionToken->csrf !== $token ) // || $user->sessionToken->hasExpired()
        //    return response("Your session id has expired, please sign in again", 404);            
        /* ********************* */        

        
        if($request->has('path')){
            $path = urldecode($request->input('path'));
            if(config('app.env') == "local")
                Storage::delete($path);
            else      /** ENV == production **/
                Storage::disk('s3')->delete($path);                      
            $mediaContent = $user->mediaContents->where('media_path',$path)->first();
            $mediaContent->delete();

            return response()->json(['success' => "destruido"]);
        }

        return response('error destroying the data to the server', 404); 
        
    }
}

?>