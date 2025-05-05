<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Login_otp extends Model
{
    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'user_id', // optional if you assign this too
    ];

}
