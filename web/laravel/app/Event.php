<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    
    protected $primaryKey = 'id_event';
    protected $fillable = array('name', 'description', 'startdate', 'enddate', 'project_id', 'imagepath');
    
    
    
    public function project()
    {
        return $this->belongsTo(Project, 'id_project');
    }
    
    
    public function get_proj_name() {
        return Project::where('id_project', $this->project_id)->first()->name;
    }
    
}
