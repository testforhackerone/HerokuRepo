<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coin extends Model
{
    protected $fillable = ['name', 'amount', 'sold_amount', 'price', 'status', 'is_active'];
}
