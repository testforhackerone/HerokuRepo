<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    protected $fillable = ['coin_id', 'user_id', 'payment_id', 'amount', 'price', 'status'];

    public function coin()
    {
        return $this->belongsTo(Coin::class,'coin_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function payment()
    {
        return $this->belongsTo(PaymentMethods::class,'payment_id');
    }
}
