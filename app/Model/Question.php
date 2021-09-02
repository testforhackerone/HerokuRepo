<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'category_id', 'sub_category_id', 'video_link', 'serial', 'image', 'type', 'hints', 'skip_coin', 'answer', 'time_limit', 'point', 'coin', 'status'];

    public function qsCategory()
    {
        return $this->belongsTo(Category::class,'category_id');
    }
    public function qsSubCategory()
    {
        return $this->belongsTo(Category::class,'sub_category_id');
    }

    public function question_option()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
