<?php

namespace App\Http\Controllers\Apis\User\Traits;

use Illuminate\Http\Request;

trait VideoUserTrait{

    public function videoSpecific(Request $request){
        if(config('app.env') == "local")
            return response()->file(storage_path('app/' . urldecode($request->path)));
        /** ENV == production **/
        return response()->file(public_path(urldecode($request->path)));
    }


}

?>