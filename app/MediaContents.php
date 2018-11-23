<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class MediaContents extends Model
{
    protected $fillable = ['media_path','media_type'];

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
