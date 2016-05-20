<?php

//onderstaande 2 regeltjes heb ik zelf toegevoegd
use App\Task;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//onderstaande heb ik zelf in commentaar gezet
/*
Route::get('/', function () {
    return view('welcome');
});
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
    
    /**
     * Show Task Dashboard //als we hierin komen krijgen we een overzicht van alle taken
     */
    /*
    Route::get('/', function () {
        //je gaat al je bestaande taken uit het model ophalen
        //$tasks = Task::orderBy('created_at', 'asc')->get();
        
        //je kan een 2de argument meegeven aan de view, namelijk je data, die je dan kan aanspreken in de view
        //als ik het tweede argument hier wegdoe krijg ik een overzicht met errors...
        //return view('tasks', [
        //    'tasks' => $tasks
        //]);
        return view('project_overview');
    });
    */
    
    /*
    Route::get('/overview', function () {
        return view('project_overview');
    });
    */
    //Route::get('/', 'BaseController@getOverview');
    
    //homepage for users
    Route::get('/', 'BaseController@getHomepage');
    
    
    //API
    Route::get('/api_test', 'ApiController@test');
    Route::get('/api_project_info/{id}', 'ApiController@project_info');
    Route::get('/get_project_info/{id}', 'ApiController@get_project_info');
    Route::get('search', ['as' => 'search', 'uses' => 'ApiController@search']);
    //get phases project
    Route::get('/get_phases_project/{id}', 'ApiController@get_phases_project');
    //get phase info
    Route::get('/get_phase_info/{id}', 'ApiController@get_phase_info');
    //get events project
    Route::get('/get_events_project/{id}', 'ApiController@get_events_project');
    //get questions phase
    Route::get('/get_questions_phase/{id}', 'ApiController@get_questions_phase');
    //get comments phase
    Route::get('/get_comments_phase/{id}', 'ApiController@get_comments_phase');
    //app
    Route::get('/get_question_ids', 'ApiController@get_current_questions');
    
    
    
    
    
    //main dashboard admins
    Route::get('/overview', 'BaseController@getOverview');
    
    Route::get('/add_project', function () {
        return view('add_project');
    });
    
    Route::get('/comments', function () {
        return view('comments');
    });
    
    
    //add views
    Route::get('/add_phase/{id}', ['as' => 'add_phase', 'uses' => 'BaseController@addPhase']);
    
    Route::get('/add_event/{id}', ['as' => 'add_event', 'uses' => 'BaseController@addEvent']);
    
    Route::get('/add_question/{id}', ['as' => 'add_question', 'uses' => 'BaseController@addQuestion']);
    
    
    //project bewerken (aangeklikt vanaf project overview)
    Route::get('/edit_project/{id}', ['as' => 'edit_project', 'uses' => 'BaseController@getEditProject']);
    
    Route::get('/edit_phase/{id}', ['as' => 'edit_phase', 'uses' => 'BaseController@getEditPhase']);
    
    Route::get('/edit_event/{id}', ['as' => 'edit_event', 'uses' => 'BaseController@getEditEvent']);
    
    
    //admin part --> get comments by phase
    Route::get('/get_comments_phase/{id}', ['as' => 'get_comments_phase', 'uses' => 'BaseController@getCommentsPhase']);
    //admin part --> get comments by project
    Route::get('/get_comments_project/{id}', ['as' => 'get_comments_project', 'uses' => 'BaseController@getCommentsProject']);
    
    //admin part --> get results by phase
    Route::get('/get_results_phase/{id}', ['as' => 'get_results_phase', 'uses' => 'BaseController@getResultsPhase']);
    //admin part --> get results by project
    Route::get('/get_results_project/{id}', ['as' => 'get_results_project', 'uses' => 'BaseController@getResultsProject']);
    
    
    //toevoegen uitvoeren (dus als er op de submit button geklikt wordt)
    Route::post('/new_project', 'BaseController@storeNewProject');
    Route::post('/new_phase', 'BaseController@storeNewPhase');
    Route::post('/new_event', 'BaseController@storeNewEvent');
    Route::post('/new_question', 'BaseController@storeNewQuestion');
    
    
    //updates uitvoeren
    Route::post('/update_project', 'BaseController@updateProject');
    Route::post('/update_phase', 'BaseController@updatePhase');
    Route::post('/update_event', 'BaseController@updateEvent');
    

    /**
     * Add New Task //als we in deze view komen kan je een nieuwe taak toevoegen
     */
    Route::post('/task', function (Request $request) {
        //hier ga je validatie specifiëren voor het name veld --> het is required en het mag max 255 karakters lang zijn
        $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
        ]);

        //als de validatie niet valid is ga je terug redirecten naar de homepagina met de ingevulde gegevens reeds ingevuld en de errors erbij
        //The ->withErrors($validator) call will flash the errors from the given validator instance into the session so that they can be accessed via the $errors variable in our view.
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }

        //als de validatie geslaagd ga je een nieuwe instantie van het model aanmaken om in de database de nieuwe task op te slagen
        $task = new Task;
        $task->name = $request->name;
        $task->save();

        //na het toevoegen ga je redirecten naar de homepagina
        return redirect('/');

    });

    /**
     * Delete Task //als we in deze view komen kan je een taak verwijderen
     */
    //hierin is {task} de id van de task die je wil gaan verwijderen en $task is het model
    Route::delete('/task/{task}', function (Task $task) {
        $task->delete();

        return redirect('/');
    });
});
