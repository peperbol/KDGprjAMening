<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    protected $fillable = array('gender_name');
    
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function answer()
    {
        return $this->hasMany(Answer::class);
    }
}
