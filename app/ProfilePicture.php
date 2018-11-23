<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ProfilePicture extends Model
{
    protected $fillable = ['profile_picture'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
