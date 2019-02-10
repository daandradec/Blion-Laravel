<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class SessionToken extends Model
{
    protected $fillable = ['csrf','expired'];
    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }
}
