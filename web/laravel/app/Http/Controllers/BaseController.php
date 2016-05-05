<?php

namespace App\Http\Controllers;

use App\Project;
use App\Phase;
use App\Event;
use App\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required|string|min:50|max:150', 
            'startdate' => 'required|date', 
            'hidden' => 'required', 
            'imagepath' => 'required|string', 
            'street' => 'required|string', 
            'house_number' => 'required|integer', 
            'latitude' => 'required', 
            'longitude' => 'required',
        ]);
    }
    
    
    //project overview
    public function getOverview() {
        $projects = Project::all();
        return view('project_overview', ["projects" => $projects]);
    }
    
    public function getOverview2() {
        //$projectphases = Projectphase::all();
        //$projects = Project::with('Projectphase')->get();
        $projs = \DB::table('projects') ->select('projects.id_project', 'projects.name as pname', 'project_phases.name as pfname') ->join('project_phases', 'projects.id_project', '=', 'project_phases.project_id') ->where('projects.id_project', '=', "2") ->get();
        
        
        return view('project_overview', ["projects" => $projs]);
    }
    
    public function getOverview3() {
        //$projectphases = Projectphase::all();
        $projects = Project::with('event')->find(2);
        //dd($projects);
        
        return view('project_overview', ['projects' => $projects]);
    }
    
    
    public function getEditProject ($id) {
        //$project = Project::where('id_project', $id)->get();
        $project = Project::with('user')->find($id);
        $user = User::where("id", $project->user_id)->get();
        $phases = Phase::where("project_id", $id)->get();
        $events = Event::where("project_id", $id)->get();
        //dd($project);
        //return view('edit_project', ['id' => $id]);
        return view('edit_project', ['project' => $project, 'user' => $user, 'phases' => $phases, 'events' => $events]);
    }
    
    public function getEditPhase ($id) {
        $phase = Phase::where("id_phase", $id)->get();
        return view('edit_phase', ['phase' => $phase]);
    }
    
    
    public function addPhase ($id) {
        //de id die hier binnenkomt is de id van het project waar de fase aan moet toegevoegd worden
        $project = Project::with('user')->find($id);
        return view('add_phase', ['project' => $project]);
    }
    
    
    
}