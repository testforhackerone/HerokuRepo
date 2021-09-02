<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CategoryUnlock extends Model
{
    protected $fillable =['user_id', 'category_id', 'status'];
}
