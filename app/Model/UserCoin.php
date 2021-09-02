<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserCoin extends Model
{
    protected $fillable = ['user_id', 'coin', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
