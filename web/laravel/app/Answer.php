<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = array('question_id', 'answer', 'gender_id', 'age');
    
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
}
