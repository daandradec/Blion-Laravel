<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\EmailVerificationReceived;
use App\ProfilePicture;
use App\MediaContents;
use App\SessionToken;

class User extends Authenticatable implements MustVerifyEmail
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



    // sobrescribiendo trait de vendor/laravel/framework/Illuminate\Auth/MustVerifyEmail
    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationReceived());
    }
}
