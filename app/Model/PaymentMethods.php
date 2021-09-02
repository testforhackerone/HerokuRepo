<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PaymentMethods extends Model
{
    protected $fillable = ['name', 'status'];
}
