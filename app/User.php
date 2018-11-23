<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ProfilePicture;
use App\MediaContents;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function profilePicture(){
        return $this->hasOne(ProfilePicture::class);
    }
    public function profilePicturePath(){
        return $this->profilePicture->profile_picture;
    }

    public function mediaContents(){
        return $this->hasMany(MediaContents::class);
    }
}
