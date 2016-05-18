<?php

namespace App\Http\Controllers;

use App\Project;
use App\Phase;
use App\Event;
use App\Question;
use App\Comment;
use App\User;

use Response;

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
        //Response::json($result)->setCallback(Input::get('callback'));
    }
    
    public function test2() {
        return response()->json(['name' => 'Abigail', 'state' => 'CA']);
    }
    
    
    public function project_info($id) {
        $project = Project::find($id);
        return response()->json($project);
        
    }
    
   
    
    public function search()
    {
        $project_id = $_GET["project_id"];
        dd($get);
        
        //$url = $request->url();
        //dd($url);
        
        //$project = Project::find($id);
        /*return response()
            ->json(['name' => 'Abigail', 'state' => 'CA'])
            ->setCallback($request->input('callback'));*/
        
        //return Response::json($project)->setCallback(Input::get('callback'));
    }
    
    
    
    //project_info
     public function get_project_info($id) {
        $project = Project::find($id);
        return response()->json($project);
    }
    
    //fases per project
    public function get_phases_project($id) {
        $phases = Phase::where("project_id", $id)->get();
        return response()->json($phases);
    }
    //event info
    public function get_events_project($id) {
        $events = Event::where("project_id", $id)->get();
        return response()->json($events);
    }
    //vragen per fase
    public function get_questions_phase($id) {
        $questions = Question::where("project_phase_id", $id)->get();
        return response()->json($questions);
    }
    //comments per fase
    public function get_comments_phase($id) {
        $comments = Comment::where("project_phase_id", $id)->get();
        return response()->json($comments);
    }
    //post van antwoorden
    //post van comments
    
    
    
}
