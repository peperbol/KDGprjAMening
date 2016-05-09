@extends('layouts.app')

@section('content')
   
   <div class="temp_content">
      <h1>Event toevoegen aan {{ $project->name }}</h1>
       
       
       <form action="{{ url('new_event') }}" method="POST" >
           {{ csrf_field() }}
           <div>
               <label for="name">Naam:</label>
               <input id="name" name="name" type="text" required>
           </div>
           
           <div>
               <label for="description">Beschrijving:</label>
               <textarea id="description" name="description" required></textarea>
           </div>
           
           <div>
               <label for="startdate">Startdatum:</label>
               <input id="startdate" name="startdate" type="date" required>
               <input id="starttime" name="starttime" type="time" required>
           </div>
           
           <div>
               <label for="enddate">Einddatum:</label>
               <input id="enddate" name="enddate" type="date" required>
               <input id="endtime" name="endtime" type="time" required>
           </div>
           
           <div>
               <label for="image">Afbeelding:</label>
               <input type="file" id="image" name="image">
           </div>
           
           
           
           <input type="number" id="project" name="id_project" value="{{ $project->id_project }}" hidden>
           
           
           
           <div>
                <button type="submit">
                    Toevoegen
                </button>
           </div>
           
       </form>
       
   </div>
   
@endsection