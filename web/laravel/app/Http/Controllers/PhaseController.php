<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PhaseController extends Controller
{
    //
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
    
    
    
    public function getOverview() {
        $projects = Project::all();
        return view('project_overview', ["projects" => $projects]);
    }
}
