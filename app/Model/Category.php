<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'coin', 'description', 'image', 'qs_limit', 'time_limit', 'max_limit', 'serial', 'status','parent_id'];

    public function question()
    {
        return $this->hasMany(Question::class);
    }

    // sub category count
    public function count_sub_category(){
        return $this->hasMany(Category::class,'parent_id','id');
    }
}
