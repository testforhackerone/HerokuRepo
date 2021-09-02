<?php

namespace App;

use App\Model\UserAnswer;
use App\Model\UserCoin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'country', 'language', 'phone', 'photo', 'active_status', 'role', 'email_verified', 'reset_code', 'city', 'state', 'zip', 'address','device_type', 'device_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function userAnswer()
    {
        return $this->hasMany(UserAnswer::class);
    }
    public function userCoin()
    {
        return $this->hasOne(UserCoin::class);
    }
}
