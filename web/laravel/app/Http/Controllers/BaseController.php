<?php

namespace App\Http\Controllers;

use Auth;
use App\Project;
use App\Phase;
use App\Event;
use App\User;
use App\Question;
use App\Comment;
use App\Answer;

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
    
    
    //users homepage
    public function getHomepage() {
        //can't be projects all
        //$projects = Project::all();
        //must be projects whose hidden = 0
        $projects = Project::where('hidden', 0)->orderBy('startdate', 'desc')->get();
        //$projects = array_reverse($projects);
        return view('homepage/home', ["projects" => $projects]);
    }
    
    
    //project overview
    public function getOverview() {
        
        if(Auth::check()) {
            $projects = Project::orderBy('startdate', 'desc')->get();
            return view('project_overview', ["projects" => $projects]);
        }
        else {
            return view('login_test');
        }
        
        
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
    
    
    
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    public function getCommentsPhase ($id) {
        $phase = Phase::find($id);
        $comments = Comment::where('project_phase_id', $id)->where('hidden', 0)->get();
        //return view('show_comments', ['phase' => $phase, 'comments' => $comments]);
        return $comments;
    }
    
    public function getResultsPhase ($id) {
        $phase = Phase::find($id);
        $questions = Question::where('project_phase_id', $id)->get();
        $results = [];
        foreach($questions as $question) {
            //for each question get the question, the option labels and the amount of votes for those options
            $questiontext = $question->questiontext;
            $leftlabel = $question->leftlabel;
            $rightlabel = $question->rightlabel;
            $leftcount = Answer::where('question_id', $question->id_question)->where('answer', 0)->count();
            $rightcount = Answer::where('question_id', $question->id_question)->where('answer', 1)->count();
            $total = $leftcount + $rightcount;
            if($total == 0) {
                $total = 1;
            }
            //left procent and right procent
            $left_procent = round($leftcount/$total*100, 2);
            $right_procent = round($rightcount/$total*100, 2);
            
            //save this question data in a variabele result
            $result = [$questiontext, $leftlabel, $rightlabel, $leftcount, $rightcount, $left_procent, $right_procent];
            //push result tot the results array
            array_push($results, $result);
            //dd($results);
            
        }
        
        return $results;
        //return view('show_results', ['phase' => $phase, 'results' => $results]);
    }
    
    
    public function getCommentsProject ($id) {
        $project_phases = Phase::where('project_id', $id)->get();
        $project = Project::find($id);
        $comments_project = [];
        foreach($project_phases as $phase){
            $phasename = $phase->name;
            $comments = $this->getCommentsPhase($phase->id_project_phase);
            array_push($comments_project, [$phase, $comments]);
        }
        return view('show_comments', ['project' => $project, 'comments_project' => $comments_project]);
    }
    
    
    public function getResultsProject ($id) {
        $project = Project::find($id);
        $project_phases = Phase::where('project_id', $id)->get();
        $results_project = [];
        foreach($project_phases as $phase){
            $phasename = $phase->name;
            $results = $this->getResultsPhase($phase->id_project_phase);
            array_push($results_project, [$phase, $results]);
        }
        //dd($results_project);
        return view('show_results', ['project' => $project, 'results_project' => $results_project]);
    }
    
    
    public function getCommentsOverview () {
        
        $projects = Project::all();
        $comments_overview = [];
        foreach($projects as $project) {
            
            $phase = Phase::where("project_id", $project->id_project)->orderBy('enddate', 'desc')->first();
            if($phase) {
                $comments = Comment::where("project_phase_id", $phase->id_project_phase)->where('hidden', 0)->get();
                array_push($comments_overview, [$project, $comments]);
            }
        }
        
        //return $comments_overview;
        return view('comments', ['comments_overview' => $comments_overview]);
    }
    
    
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    
    
    
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
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
        return view('edit_phase', ['phase' => $phase[0]]);
    }
    
    public function getEditEvent ($id) {
        $event = Event::find($id);
        //startdate and enddate are datetime --> must be converted to date and time
        $startdate_arr = explode(" ", $event->startdate);
        $enddate_arr = explode(" ", $event->enddate);
        
        return view('edit_event', ['event' => $event, 'startdate_arr' => $startdate_arr, 'enddate_arr' => $enddate_arr]);
    }
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    
    
    
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
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
        return view('add_question', ['phase' => $phase[0]]);
    }
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    
    
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    //store / insert views
    //effectief toevoegen aan database (de werkelijke insert)
    public function storeNewProject(Request $request)
    {
        //dd($request);
        
        
        $imagepath = null;
        $imagepath = $this->storeImage($request, "image");
        
        
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
        
        
        //project_id for new fase
        $project_id = $project->id_project;
        
        //en ook ineens de nieuwe fase toevoegen
        
        $phase_imagepath = null;
        $phase_imagepath = $this->storeImage($request, "phase_image");
        
        $bannerpath = null;
        $order = 1;
        
        $phase = new Phase(['name' => $request->phase_name,
                            'description' => $request->phase_description,
                            'enddate' => $request->phase_enddate,
                            'order' => $order,
                            'bannerpath' => $bannerpath,
                            'imagepath' => $phase_imagepath,
                            'project_id' => $project_id
                           ]);
        
        $phase->save();
        
        
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/overview');
    }
    
    public function storeNewPhase(Request $request)
    {
        //the path where the images will be stored
        $imagepath = null;
        $imagepath = $this->storeImage($request, "image");
        
        $bannerpath = null;
        
        $order = 0;
        
        //op manier volgens https://laravel.com/docs/5.0/eloquent#inserting-related-models
        $phase = new Phase(['name' => $request->name,
                            'description' => $request->description,
                            'enddate' => $request->enddate,
                            'order' => $order,
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
        
        
        $imagepath = $this->storeImage($request, "image");
        
        
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
    
    
    public function storeNewQuestion(Request $request)
    {
        
        $hidden = 0;
        
        //voor de image, moeten we deze eerst gaan opslagen op de server op een bepaald destination path en dan dat path in de database opslagen
        $left_picture_path = null;
        $right_picture_path = null;
        
        
        $left_picture_path = $this->storeQuestionImage($request, 'left_picture_path');
        $right_picture_path =$this->storeQuestionImage($request, 'right_picture_path');
        
        //op manier volgens https://laravel.com/docs/5.0/eloquent#inserting-related-models
        $question = new Question(['questiontext' => $request->questiontext,
                                'leftlabel' => $request->leftlabel,
                                'rightlabel' => $request->rightlabel,
                                'left_picture_path' => $left_picture_path,
                                'right_picture_path' => $right_picture_path,
                                'hidden' => $hidden,
                                'project_phase_id' => $request->id_phase
                                ]);
        
        $question->save();
        
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/add_question/' . $request->id_phase);
    }
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    
    
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    //updates
    public function updateProject(Request $request)
    {
        //dd($request);
        
        $project = Project::find($request->id_project);
        
        //default $imagepath is null so it won't be changed when no new image was selected
        $imagepath = null;
        $imagepath = $this->storeImage($request, "image");
        
        //als de checkbox aangevinkt is, krijg je de waarde 1 terug, anders is de waarde blank
        $hidden = $request->hidden;
        //als hij niet aangevinkt is moeten we de 0 doorgeven:
        if($hidden != 1) {
            $hidden = 0;
        }
        
        
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
    
    public function updatePhase(Request $request)
    {
        $phase = Phase::find($request->id_phase);
        //$phase = Phase::where("id_project_phase", $request->id_phase)->get();
        //dd($phase[0]);
        //$phase = $phase[0];
        //dd($request);
        
        //default $imagepath is null so it won't be changed when no new image was selected
        $imagepath = null;
        $imagepath = $this->storeImage($request, "image");
        
        
        
        $bannerpath = null;
        
        
        $phase->name = $request->name;
        $phase->description = $request->description;
        $phase->enddate = $request->enddate;
        if($imagepath) {
            $phase->imagepath = $imagepath;
        }
        //dd($phase);
        $phase->save();
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/overview');
    }
    
    public function updateEvent(Request $request)
    {
        $event = Event::find($request->id_event);
        //$phase = Phase::where("id_project_phase", $request->id_phase)->get();
        //dd($phase[0]);
        //$phase = $phase[0];
        //dd($request);
        
        //default $imagepath is null so it won't be changed when no new image was selected
        $imagepath = null;
        
        $imagepath = $this->storeImage($request, "image");
        
        $startdate = $this->convertToMysqlDatetime($request->startdate, $request->starttime);
        $enddate = $this->convertToMysqlDatetime($request->enddate, $request->endtime);
        
        $event->name = $request->name;
        $event->description = $request->description;
        $event->startdate = $startdate;
        $event->enddate = $enddate;
        if($imagepath) {
            $event->imagepath = $imagepath;
        }
        //dd($phase);
        $event->save();
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        return redirect('/overview');
    }
    
    //hide comment in comment overview of project
    public function hideComment($id)
    {
        $comment = Comment::find($id);
        
        $comment->hidden = 1;
        
        $comment->save();
        
        $phase = Phase::find($comment->project_phase_id);
        $project = Project::find($phase->project_id);
        
        //dd($comment);
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        //id of project should be appended
        return redirect('/get_comments_project/' . $project->id_project);
    }
    
    //hide comment in total overview of all comments on all projects
    public function hideCommentFromTotalOverview($id)
    {
        $comment = Comment::find($id);
        
        $comment->hidden = 1;
        
        $comment->save();
        
        $phase = Phase::find($comment->project_phase_id);
        $project = Project::find($phase->project_id);
        
        //dd($comment);
        
        //hier moet de redirect wel nog staan, want indien het valideren en inserten lukt, gaat hij niet automatisch redirecten
        //id of project should be appended
        return redirect('/comments');
    }
    
    
    /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    
    
    
    // extra functions
    
    function convertToMysqlDatetime( $date , $time ) {
        $datetime = $date . " " . $time;
        return $datetime;
    }
    
    
    function storeImage($request, $filename) {
        //the path where the images will be stored
        $project_images_path = public_path() . "\\images\\project_images\\";
        //dd(base_path());
        //allowed extensions
        $allowed_extensions = ["jpeg", "png"];
        
        
        /* image must be
        *       checked for extension
        *       moved to directory on server
        *       path opslagen in database
        */
        
        if ($request->hasFile($filename) && $request->file($filename)->isValid()) {
            
            $file = $request->file($filename);
            //check whether file extension is valid
            if (in_array($file->guessClientExtension(), $allowed_extensions)) {
                
                //the time stamp will be added to uploaded images to prevent identical names
                $timestamp = time();
                //create new file name
                $new_file_name = $timestamp . $file->getClientOriginalName();
                
                //everything ok? -> save image on server
                $file->move(base_path() . '/public/images/project_images/', $new_file_name);
                
                $imagepath = $new_file_name;
                return $imagepath;
            }
            else {
                // not ok return to add project view with error
            }
        }
    }
    
    function storeQuestionImage($request, $name) {
        //the path where the images will be stored
        $project_images_path = public_path() . "\\images\\question_images\\";
        
        //allowed extensions
        $allowed_extensions = ["jpeg", "png"];
        
        
        /* image must be
        *       checked for extension
        *       moved to directory on server
        *       path opslagen in database
        */
        
        if ($request->hasFile($name) && $request->file($name)->isValid()) {
            
            $file = $request->file($name);
            //check whether file extension is valid
            if (in_array($file->guessClientExtension(), $allowed_extensions)) {
                
                //the time stamp will be added to uploaded images to prevent identical names
                $timestamp = time();
                //create new file name
                $new_file_name = $timestamp . $file->getClientOriginalName();
                
                //everything ok? -> save image on server
                $file->move(base_path() . '/public/images/question_images/', $new_file_name);
                
                $imagepath = $new_file_name;
                return $imagepath;
            }
            else {
                // not ok return to add project view with error
            }
        }
    }
    
    
    
}