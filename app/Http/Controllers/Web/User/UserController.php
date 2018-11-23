<?php

namespace App\Http\Controllers\Web\User;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\FileUploadRequest;
use Illuminate\Http\Request;
use App\MediaContents;
use App\User;

class UserController extends Controller{

    public function show(){
        return view('user.show');
    }

    public function update(ImageUploadRequest $request, $id){
        $user = User::findOrFail($id);
        
        if($request->hasFile('picture')){
            $picture = $user->profilePicture;
            if(strcmp($picture->profile_picture,"public/Users/no-avatar.jpg"))
                Storage::delete($picture->profile_picture);
            $picture->profile_picture = $request->file('picture')->store('public/Users/'.$user->email);
            $picture->save();
            return back()->with('status','Cambios Guardados Correctamente');
        }
        
        return back()->with('fail','Formato de archivo incorrecto o vacio');
    }

    public function contents(){    
        $user = auth()->user();
        $user_id = $user->id;
        $media_images = $user->mediaContents->where('media_type','image');   
        $media_videos = $user->mediaContents->where('media_type','video');     
        return view('user.contents',compact(['user_id','media_images','media_videos']) );
    }

    public function contentStore(FileUploadRequest $request,$id){
        $user = User::findOrFail($id);        

        if($request->hasFile('mediafile')){
            $type = $request->file('mediafile')->getMimeType();
            $type = substr($type, 0, strpos($type, "/"));

            if($type == "image")
                $user->mediaContents()->create(['media_path'=>$request->file('mediafile')->store('public/Users/'.$user->email),'media_type'=>'image']);
            if($type == "video")
                $user->mediaContents()->create(['media_path'=>$request->file('mediafile')->store('public/Users/'.$user->email),'media_type'=>'video']);
            return back()->with('status','Archivo Almacenado');
        }

        return back()->with('fail','Formato de archivo incorrecto o vacio');
    }

    public function contentDestroy($id){
        $mediaContent = MediaContents::findOrFail($id);
        Storage::delete($mediaContent->media_path);
        $mediaContent->delete();
        return back()->with('status','Archivo eliminado');
    }
}