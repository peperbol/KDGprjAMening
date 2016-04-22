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
    Route::get('/', function () {
        //je gaat al je bestaande taken uit het model ophalen
        $tasks = Task::orderBy('created_at', 'asc')->get();
        
        //je kan een 2de argument meegeven aan de view, namelijk je data, die je dan kan aanspreken in de view
        //als ik het tweede argument hier wegdoe krijg ik een overzicht met errors...
        return view('tasks', [
            'tasks' => $tasks
        ]);
    });

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
