<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuizResult extends Model
{
    protected $fillable = ['user_id', 'category_id', 'score', 'coin', 'status'];
}
