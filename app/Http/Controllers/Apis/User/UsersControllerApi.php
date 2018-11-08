<?php

namespace App\Http\Controllers\Apis\User;

use Illuminate\Http\Request;
use Traits\ImageUserTraitApi;

class UsersControllerApi extends Controller
{
    use ImageUserTraitApi;

    public function index($id){
        $user = User::find($id);
        if($user == null)
            return response()->json(['success' => false,'name' => '','email' => '']);
        return response()->json(['success' => true,'name' => $user->name,'email' => $user->email]);
    }
}
