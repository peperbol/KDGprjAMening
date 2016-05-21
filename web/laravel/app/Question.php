<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    
    protected $primaryKey = "id_question";
    protected $fillable = array('questiontext', 'leftlabel', 'rightlabel', 'left_picture_path', 'right_picture_path', 'project_phase_id', 'hidden');
    
    public function phase()
    {
        return $this->belongsTo(Phase::class);
    }
    
    public function answer()
    {
        return $this->hasMany(Answer::class);
    }
    
}
