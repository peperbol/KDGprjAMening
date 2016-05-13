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
    
    
    //users homepage
    public function getHomepage() {
        $projects = Project::all();
        return view('homepage/home', ["projects" => $projects]);
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
        $phase = Phase::where("id_project_phase", $id)->get();
        return view('edit_phase', ['phase' => $phase]);
    }
    
    
    //add views
    public function addPhase ($id) {
        //the id passed to this function is the id from the project to which the phase must be added
        $project = Project::with('user')->find($id);
        return view('add_phase', ['project' => $project]);
    }
    
    public function addEvent ($id) {
        //the id passed to this function is the id from the project to which the event must be added
        $project = Project::with('user')->find($id);
        return view('add_event', ['project' => $project]);
    }
    
    public function addQuestion ($id) {
        //the id passed to this function is the id from the project to which the event must be added
        $phase = Phase::where("id_project_phase", $id)->get();
        return view('add_question', ['phase' => $phase]);
    }
    
    
    //store / insert views
    //effectief toevoegen aan database (de werkelijke insert)
    public function storeNewProject(Request $request)
    {
        //dd($request);
        
        //the path where the images will be stored
        $project_images_path = public_path() . "\\images\\project_images\\";
        
        //allowed extensions
        $allowed_extensions = ["jpeg", "png"];
        
        
        /* image must be
        *       checked for extension
        *       moved to directory on server
        *       path opslagen in database
        */
        
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            
            $file = $request->file('image');
            //check whether file extension is valid
            if (in_array($file->guessClientExtension(), $allowed_extensions)) {
                
                //the time stamp will be added to uploaded images to prevent identical names
                $timestamp = time();
                //create new file name
                $new_file_name = $timestamp . $file->getClientOriginalName();
                
                //everything ok? -> save image on server
                $file->move($project_images_path, $new_file_name);
                
                $imagepath = $project_images_path . $new_file_name;
                
            }
            else {
                // not ok return to add project view with error
            }
            //dd($request->file('image')->getClientOriginalExtension());
            //dd($project_images_path);
        }
        
        
        
        
        //als de checkbox aangevinkt is, krijg je de waarde 1 terug, anders is de waarde blank
        $hidden = $request->hidden;
        //als hij niet aangevinkt is moeten we de 0 doorgeven:
        if($hidden != 1) {
            $hidden = 0;
        }
        
        
        //user_id moet ook meegegeven worden via de url + controller en moet hier dan worden toegekend --> moet nog gedaan worden
        $user = 1; // VOORLOPIG !!!!
        
        //aangezien we nummer niet meer gaan gebruiken, maar het hele adres in street steken, gaan we house_number gewoon standaard op 1 zetten
        $house_number = 1;
        
        //op manier volgens https://laravel.com/docs/5.0/eloquent#inserting-related-models
        $project = new Project(['name' => $request->name,
                                'description' => $request->description,
                                'startdate' => $request->startdate,
                                'hidden' => $hidden,
                                'imagepath' => $imagepath,
                                'street' => $request->street,
                                'house_number' => $house_number,
                                'latitude' => $request->latitude,
                                'longitude' => $request->longitude,
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
    
    
    
    //updates
    public function updateProject(Request $request)
    {
        //dd($request);
        
        $project = Project::find($request->id_project);
        
        //als de checkbox aangevinkt is, krijg je de waarde 1 terug, anders is de waarde blank
        $hidden = $request->hidden;
        //als hij niet aangevinkt is moeten we de 0 doorgeven:
        if($hidden != 1) {
            $hidden = 0;
        }
        
        //voor de image, moeten we deze eerst gaan opslagen op de server op een bepaald destination path en dan dat path in de database opslagen
        $imagepath = null;
        
        if($request->street == "") {
            $street = $request->street_old;
        }
        else {
            $street = $request->street;
        }
        
        //aangezien we nummer niet meer gaan gebruiken, maar het hele adres in street steken, gaan we house_number gewoon standaard op 1 zetten
        $house_number = 1;
        
        $project->name = $request->name;
        $project->description = $request->description;
        $project->startdate = $request->startdate;
        $project->hidden = $hidden;
        $project->imagepath = $imagepath;
        $project->street = $street;
        $project->house_number = $house_number;
        $project->latitude = $request->latitude;
        $project->longitude = $request->longitude;
        $project->user_id = $request->user;
        
        $project->save();
        
        //nog een flash message
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/overview');
    }
    
    
    
    
    
    
    // extra functions
    
    function convertToMysqlDatetime( $date , $time ) {
        $datetime = $date . " " . $time;
        return $datetime;
    }
    
    
    
}