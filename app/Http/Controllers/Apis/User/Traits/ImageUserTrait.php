<?php

namespace App\Http\Controllers\Apis\User\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use App\User;

trait ImageUserTrait{

    public function image($id){        
        return Image::make(Storage::get(User::findOrFail($id)->avatar))->response();        
    }

    public function postImage(Request $request,$id){        

        $str_img = $request->input('file');
        $str_img = str_replace(@"%2B","+",$str_img);
        $str_img = str_replace(@"%2F","/",$str_img);
        $str_img = str_replace(@"%3D","=",$str_img);

        $user = User::findOrFail($id);

        return response()->json(['sucess' => $user->id]);

        Storage::put('public/foo.png',base64_decode($str_img));

        $path = Storage::putFile('public/Users/'.$user->email,new File( public_path(Storage::url('public/foo.png')) ));

        Storage::delete('public/foo.png');

        
        if(strcmp($user->avatar,"public/Users/no-avatar.jpg"))
            Storage::delete($user->avatar);
        $user->avatar = $path;
        $user->save();

        return response()->json(['sucess' => "agregado"]);
    }

}
?>