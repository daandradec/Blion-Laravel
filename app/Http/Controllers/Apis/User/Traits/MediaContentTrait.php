<?php

namespace App\Http\Controllers\Apis\User\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\File;
use App\User;

trait MediaContentTrait{

    public function profilePicture($id){ // GET
        if(config('app.env') == "local")
            return Storage::response(User::findOrFail($id)->profilePicturePath());
        /** ENV == production **/
        return response()->file( storage_path('app/' . User::findOrFail($id)->profilePicturePath()) );  
    }

    public function postProfilePicture(Request $request, $id){ // POST

        if($request->hasFile('mediafile')){
            $user = User::findOrFail($id);
            $picture = $user->profilePicture;
            if(config('app.env') == "local"){                
                if(strcmp($picture->profile_picture,"public/Users/no-avatar.jpg"))
                    Storage::delete($picture->profile_picture);
                $picture->profile_picture = $request->file('mediafile')->store('public/Users/'.$user->email);
                $picture->save();
                return response()->json(['sucess' => "enviado"]);
            }
            if(config('app.env') == "production"){
                return response()->json(['sucess' => "En produccion instala AWS S3"]);
            }
        }
            
        return response('error sending the data to the server', 404); 
    }

    public function mediaContent(Request $request){ // GET
        
        if($request->has('path')){
            if(config('app.env') == "local"){
                $path = urldecode($request->path);
                return Storage::response($path);
            }
            if(config('app.env') == "production")
                return response()->file(public_path(urldecode($request->path)));
        }

        return response('error sending the data to the server', 404); 
    }

    public function postMediaContent(Request $request, $id){ // POST

        if($request->hasFile('mediafile')){
            $user = User::findOrFail($id);
            $type = $request->file('mediafile')->getMimeType();
            $type = substr($type, 0, strpos($type, "/"));

            if(config('app.env') == "local"){  
                $path = $request->file('mediafile')->store('public/Users/'.$user->email);
                if($type == "image")
                    $user->mediaContents()->create(['media_path'=> $path, 'media_type'=>'image']);
                if($type == "video")
                    $user->mediaContents()->create(['media_path'=> $path,'media_type'=>'video']);

                return response()->json(['success' => true,'message' => urlencode($path)]);
            }
            if(config('app.env') == "production"){
                return response()->json(['sucess' => "En produccion instala AWS S3"]);
            }
        }
            
        return response('error sending the data to the server', 404); 
    }

    public function postDestroyMediaContent(Request $request, $id){
        $user = User::findOrFail($id);
        if(config('app.env') == "local"){
            $path = urldecode($request->input('path'));
            
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