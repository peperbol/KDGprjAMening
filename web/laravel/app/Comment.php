<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = array('project_phase_id', 'comment', 'hidden', 'name', 'gender_id', 'age');
    
    public function projectphase()
    {
        return $this->belongsTo(Projectphase::class);
    }
    
    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }
}
