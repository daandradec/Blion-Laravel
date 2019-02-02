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
        return Storage::disk('s3')->response(User::findOrFail($id)->profilePicturePath());
    }

    public function postProfilePicture(Request $request, $id){ // POST

        if($request->hasFile('mediafile')){
            $user = User::findOrFail($id);
            $picture = $user->profilePicture;
            if(config('app.env') == "local"){                
                if(strcmp($picture->profile_picture,"public/Users/no-avatar.jpg"))
                    Storage::delete($picture->profile_picture);
                $picture->profile_picture = $request->file('mediafile')->store('public/Users/'.$user->email);
            }else{      /** ENV == production **/
                if(strcmp($picture->profile_picture,"public/Media/no-avatar.jpg"))
                    Storage::disk('s3')->delete($picture->profile_picture);
                $picture->profile_picture = Storage::disk('s3')->putFile('public/Media/'.$user->email, $request->file('mediafile')); 
            }
            $picture->save();
            return response()->json(['sucess' => "enviado"]);            
        }
            
        return response('error sending the data to the server', 404); 
    }

    public function mediaContent(Request $request){ // GET
        
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
            }else{      /** ENV == production **/
                $path = Storage::disk('s3')->putFile('public/Media/'.$user->email, $request->file('mediafile'));
                if($type == "image")
                    $user->mediaContents()->create(['media_path'=> $path, 'media_type'=>'image']);
                if($type == "video")
                    $user->mediaContents()->create(['media_path'=> $path,'media_type'=>'video']);                
            }
        }
            
        return response('error sending the data to the server', 404); 
    }

    public function postDestroyMediaContent(Request $request, $id){
        $user = User::findOrFail($id);        
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