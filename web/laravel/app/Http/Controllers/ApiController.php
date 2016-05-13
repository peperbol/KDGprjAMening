<?php

namespace App\Http\Controllers;

use App\Project;
use App\Phase;
use App\Event;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    //
    public function __construct()
    {
        
    }
    
    
    public function test() {
        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    }
    
    
    public function project_info($id) {
        $project = Project::find($id);
        return response()->json($project);
        
    }
    
    
}
