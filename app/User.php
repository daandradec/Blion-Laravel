<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\EmailVerificationReceived;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\ProfilePicture;
use App\MediaContents;
use App\SessionToken;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
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



    /* JWT METHODS */
     /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
