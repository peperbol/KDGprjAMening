<?php

namespace App\Http\Controllers;

use App\Project;
use App\Phase;
use App\Event;
use App\Question;
use App\Comment;
use App\Answer;
use App\Gender;
use App\User;

use Response;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

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
    
    
    //get genders
    public function get_genders() {
        $genders = Gender::all();
        return response()->json($genders);
    }
    
    
    //project_info
     public function get_project_info($id) {
        $project = Project::find($id);
        return response()->json($project);
    }
    
    //fases per project
    public function get_phases_project($id) {
        //hier eventueel nog ne order by einddatum
        $phases = Phase::where("project_id", $id)->get();
        return response()->json($phases);
    }
    //get phase info
    public function get_phase_info($id) {
        $phase = Phase::find($id);
        //here you're going to ask for the last phase of this project
        $current_phase = Phase::where("project_id", $phase->project_id)->orderBy('enddate', 'desc')->first();
        //dd($current_phase);
        if($phase->enddate == $current_phase->enddate) {
            $is_current = true;
        }
        else {
            $is_current = false;
        }
        
        return response()->json([$phase, 'is_current' => $is_current]);
    }
    //event info
    public function get_events_project($id) {
        $events = Event::where("project_id", $id)->get();
        return response()->json($events);
    }
    //vragen per fase
    public function get_questions_phase($id) {
        $phase = Phase::find($id);
        $questions = Question::where("project_phase_id", $id)->get();
        return response()->json([$phase, $questions]);
    }
    //get question info
    public function get_question_info($id) {
        $question = Question::find($id);
        return response()->json($question);
    }
    //comments per fase
    public function get_comments_phase($id) {
        $comments = Comment::where("project_phase_id", $id)->get();
        return response()->json($comments);
    }
    //post van antwoorden
    public function store_new_answer(Request $request) {
        
        //request contains gender, age, question_id, answer (0 or 1)
        //for each request a new answer must be created
        $answer = new Answer(['answer' => $request->answer,
                            'age' => $request->age,
                            'question_id' => $request->question_id,
                            'gender_id' => $request->gender_id
                            ]);
        
        $answer->save();
        
        //geen redirect, want dit is gewoon iets dat uitgevoerd moet worden op de achtergrond
        return response()->json(['status' => "success"]);
    }
    //post van comments
    public function store_new_comment(Request $request) {
        
        //request contains name, gender, age, comment, project_phase_id
        //for each request a new comment must be created
        //hidden is 0 default
        $hidden = 0;
        
        $comment = new Comment(['name' => $request->name,
                                'age' => $request->age,
                                'comment' => $request->comment,
                                'gender_id' => $request->gender_id,
                                'hidden' => $hidden,
                                'project_phase_id' => $request->project_phase_id
                                ]);
        
        $comment->save();
        
        //geen redirect, want dit is gewoon iets dat uitgevoerd moet worden op de achtergrond
        return response()->json(['status' => "success"]);
        
    }
    
    public function store_test(Request $request) {
        
        //dd($request);
        return response()->json(['test' => $request->email]);
        //geen redirect, want dit is gewoon iets dat uitgevoerd moet worden op de achtergrond
    }
    
    
    
    // app API extra functions
    //return question_ids from all current phases
    public function get_current_questions() {
        //checken of question tot één van de current phases hoort
        //voor elk project current phase gaan ophalen
        //voor elk van die current phases de question id's teruggeven
        $projects = Project::where('hidden', 0)->get();
        $question_ids = [];
        foreach($projects as $project) {
            $current_phase = Phase::where("project_id", $project->id_project)->orderBy('enddate', 'desc')->first();
            //$current_phase = Phase::where("project_id", 2)->get();
            if($current_phase) {
                $questions = Question::where("project_phase_id", $current_phase->id_project_phase)->get();
                foreach($questions as $question) {
                    array_push($question_ids, $question->id_question);
                }
            }
        }
        
        return response()->json($question_ids);
    }
    
    public function get_image($id) {
        //this function will be called when there's only one picture available
        $question = Question::find($id);
        
        return Redirect::to('http://petrichor.multimediatechnology.be/images/question_images/'.$question->left_picture_path);
        
        //return response()->json($question_ids);
    }
    
    public function get_image_side($id, $side) {
        //this function will be called to get either the left_picture or the right_picture
        $question = Question::find($id);
        
        if($side == "l") {
            $picture_path = $question->left_picture_path;
        }
        if($side == "r") {
            $picture_path = $question->right_picture_path;
        }
        
        return Redirect::to('http://petrichor.multimediatechnology.be/images/question_images/'.$picture_path);
        
        //return response()->json($question_ids);
    }
    
    
    
}
