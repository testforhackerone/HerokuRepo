<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $fillable = ['question_id', 'option_title', 'option_image', 'serial', 'is_answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
