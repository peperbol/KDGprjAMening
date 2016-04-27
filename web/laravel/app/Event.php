<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = array('name', 'description', 'startdate', 'enddate', 'project_id', 'imagepath');
    
    
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
