<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    //
    protected $primaryKey = 'id_project_phase';
    protected $fillable = array('project_id', 'enddate', 'order', 'description', 'bannerpath', 'imagepath', 'name');
    
    
    
    public function project()
    {
        return $this->belongsTo(Project, 'id_project');
    }
    
    public function question()
    {
        return $this->hasMany(Question::class);
    }
    
    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
    
}
