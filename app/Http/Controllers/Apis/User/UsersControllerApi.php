<?php

namespace App\Http\Controllers\Apis\User;

use App\Http\Controllers\Apis\User\Traits\ImageUserTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UsersControllerApi extends Controller
{
    use ImageUserTrait;

    public function index($id){
        $user = User::find($id);
        if($user == null)
            return response()->json(['success' => false,'name' => '','email' => '']);
        return response()->json(['success' => true,'name' => $user->name,'email' => $user->email]);
    }
}
