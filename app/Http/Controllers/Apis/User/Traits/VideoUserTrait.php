<?php

namespace App\Http\Controllers\Apis\User\Traits;

use Illuminate\Http\Request;

trait VideoUserTrait{

    public function videoSpecific(Request $request){
        return response()->file(storage_path('app/' . $request->path));
    }


}

?>