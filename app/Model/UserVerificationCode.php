<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserVerificationCode extends Model
{
    protected $fillable = [
        'user_id','type','code','expired_at','status'
    ];
}
