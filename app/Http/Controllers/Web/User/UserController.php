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

    public function __construct(){
        $this->middleware('verified',[ 'only'=>['show','contents','index'] ]);
    }

    public function index(){        
        return view('user.index',['users'=>User::all()]);
    }

    public function show(){
        return view('user.show');
    }

    public function update(ImageUploadRequest $request, $id){
        $user = User::findOrFail($id);
        
        if($request->hasFile('picture')){
            $picture = $user->profilePicture;
            
            if(config('app.env') == "local"){
                if(strcmp($picture->profile_picture,"public/Users/no-avatar.jpg"))
                    Storage::delete($picture->profile_picture);
                $picture->profile_picture = $request->file('picture')->store('public/Users/'.$user->email);                             
            }else{      /** ENV == production **/
                if(strcmp($picture->profile_picture,"public/Media/no-avatar.jpg"))
                    Storage::disk('s3')->delete($picture->profile_picture);
                $picture->profile_picture = Storage::disk('s3')->putFile('public/Media/'.$user->email, $request->file('picture'),"public"); 
            }
                
            
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

            if(config('app.env') == "local"){
                if($type == "image")
                    $user->mediaContents()->create(['media_path'=> $request->file('mediafile')->store('public/Users/'.$user->email),'media_type'=>'image']);
                if($type == "video")
                    $user->mediaContents()->create(['media_path'=> $request->file('mediafile')->store('public/Users/'.$user->email),'media_type'=>'video']);
            }else{      /** ENV == production **/
                if($type == "image")
                    $user->mediaContents()->create(['media_path'=> Storage::disk('s3')->putFile('public/Media/'.$user->email, $request->file('mediafile'),"public") ,'media_type'=>'image']);
                if($type == "video")
                    $user->mediaContents()->create(['media_path'=> Storage::disk('s3')->putFile('public/Media/'.$user->email, $request->file('mediafile'),"public") ,'media_type'=>'video']);
            }

            
            return back()->with('status','Archivo Almacenado');
        }

        return back()->with('fail','Formato de archivo incorrecto o vacio');
    }

    public function contentDestroy($id){
        $mediaContent = MediaContents::findOrFail($id);

        if(config('app.env') == "local")
            Storage::delete($mediaContent->media_path);
        else{       /** ENV == production **/
            Storage::disk('s3')->delete($mediaContent->media_path);
        }
            
            
        $mediaContent->delete();
        return back()->with('status','Archivo eliminado');
    }
}