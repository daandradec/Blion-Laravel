<?php

namespace App\Repositories;

trait ApiHelpers{

    protected function responseStatusMessage($message, $status){
        $this->message = $message;
        $this->status = $status;
    }

    protected function reduceElloquentCollection($array){
        unset($array['created_at']);
        unset($array['updated_at']);
        return $array;
    }    
    
    protected function appendFields($array, $keys, $values){
        for( $i = 0; $i < sizeof($keys); ++$i)
            $array[$keys[$i]] = $values[$i];
        return $array;
    }
}