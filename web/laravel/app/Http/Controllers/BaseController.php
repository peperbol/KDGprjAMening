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
    
    
    //add views
    public function addPhase ($id) {
        //de id die hier binnenkomt is de id van het project waar de fase aan moet toegevoegd worden
        $project = Project::with('user')->find($id);
        return view('add_phase', ['project' => $project]);
    }
    
    public function addEvent ($id) {
        //de id die hier binnenkomt is de id van het project waar de fase aan moet toegevoegd worden
        $project = Project::with('user')->find($id);
        return view('add_event', ['project' => $project]);
    }
    
    
    
    //store / insert views
    //effectief toevoegen aan database (de werkelijke insert)
    public function storeNewProject(Request $request)
    {
        //dd($request);
        
        //als de checkbox aangevinkt is, krijg je de waarde 1 terug, anders is de waarde blank
        $hidden = $request->hidden;
        //als hij niet aangevinkt is moeten we de 0 doorgeven:
        if($hidden != 1) {
            $hidden = 0;
        }
        
        //voor de image, moeten we deze eerst gaan opslagen op de server op een bepaald destination path en dan dat path in de database opslagen
        $imagepath = null;
        
        //user_id moet ook meegegeven worden via de url + controller en moet hier dan worden toegekend --> moet nog gedaan worden
        $user = 1; // VOORLOPIG !!!!
        
        //op manier volgens https://laravel.com/docs/5.0/eloquent#inserting-related-models
        $project = new Project(['name' => $request->name,
                                'description' => $request->description,
                                'startdate' => $request->startdate,
                                'hidden' => $hidden,
                                'imagepath' => $imagepath,
                                'street' => $request->street,
                                'house_number' => $request->number,
                                'latitude' => null,
                                'longitude' => null,
                                'user_id' => $user
                               ]);
        
        $project->save();
        
        //of ipv hierboven het user_id toe te voegen kan je ook het volgende doen:
        //$user = User::find($id);
        //$project = $user->projects()->save($project);
        
        
        //gaan valideren (eventueel, maar kan ook via angular denk ik)
        /*
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);*/
        
        //ik moet hier de status ook al meegeven en het dus op onderstaande manier doen
        /*
        $request->user()->projects()->create([
            'name' => $request->name,
            'description' => 'testjeeeee',
        ]);
        */
        
        
        //volgens de documentatie op laravel zelf, moet je wel de save method gebruiken (???)
        //$project = new Project(['name' => $request->name]);

        //$user = User::find(1);

        //$comment = $post->comments()->save($comment);
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/overview');
    }
    
    public function storeNewPhase(Request $request)
    {
        
        //voor de image, moeten we deze eerst gaan opslagen op de server op een bepaald destination path en dan dat path in de database opslagen
        $imagepath = null;
        $bannerpath = null;
        
        //op manier volgens https://laravel.com/docs/5.0/eloquent#inserting-related-models
        $phase = new Phase(['name' => $request->name,
                            'description' => $request->description,
                            'enddate' => $request->enddate,
                            'order' => $request->order,
                            'imagepath' => $imagepath,
                            'bannerpath' => $bannerpath,
                            'project_id' => $request->id_project
                            ]);
        
        $phase->save();
        
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/overview');
    }
    
    public function storeNewEvent(Request $request)
    {
        
        //voor de image, moeten we deze eerst gaan opslagen op de server op een bepaald destination path en dan dat path in de database opslagen
        $imagepath = null;
        
        $startdate = $this->convertToMysqlDatetime($request->startdate, $request->starttime);
        $enddate = $this->convertToMysqlDatetime($request->enddate, $request->endtime);
        
        //op manier volgens https://laravel.com/docs/5.0/eloquent#inserting-related-models
        $event = new Event(['name' => $request->name,
                            'description' => $request->description,
                            'startdate' => $startdate,
                            'enddate' => $enddate,
                            'imagepath' => $imagepath,
                            'project_id' => $request->id_project
                            ]);
        
        $event->save();
        
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/overview');
    }
    
    
    
    
    
    
    // extra functions
    
    function convertToMysqlDatetime( $date , $time ) {
        //
        /*
        $new_date = str_replace('-', ',', $date);
        $new_time = str_replace(':', ',', $time);
        //de nul hieronder staat voor het aantal seconden
        $datetime_comma = $new_time.',0,'.$new_date;
        $fulldate = explode(',',$datetime_comma);
        $h = $fulldate[0];
        $i = $fulldate[1];
        $s = $fulldate[2];
        $m = $fulldate[3];
        $d =$fulldate[4];
        $y = $fulldate[5];
        
        $newdate2 = date("Y-m-d H:i:s",mktime($h,$i,$s,$m,$d,$y));
        echo $newdate2;
        */
        $datetime = $date . " " . $time;
        return $datetime;
    }
    
    
    
}