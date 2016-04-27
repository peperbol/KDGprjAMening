<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $fillable = ['name'];
    protected $fillable = array('name', 'description', 'startdate', 'hidden', 'user_id', 'imagepath', 'street', 'house_number', 'latitude', 'longitude');
    
    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function event()
    {
        return $this->hasMany(Event::class);
    }
    
    public function projectphase()
    {
        return $this->hasMany(Projectphase::class);
    }
}
