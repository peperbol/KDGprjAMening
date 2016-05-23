@extends('layouts.app')

@section('content')
   
   <div class="variable_content">
     
     <div class="pageContent">
       
       
           <form class="add_event_form" action="{{ url('new_event') }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               
               <h3 class="title">Event toevoegen aan {{ $project->name }}</h3>
               
               <div>
                   <label for="name">Naam:</label>
                   <input id="name" name="name" type="text" required>
               </div>

               <div>
                   <label for="description">Beschrijving:</label>
                   <textarea id="description" name="description" required></textarea>
               </div>

               <div>
                   <label for="startdate">Startdatum en tijd:</label>
                   <input id="startdate" name="startdate" type="date" required>
                   <input id="starttime" name="starttime" type="time" required>
               </div>

               <div>
                   <label for="enddate">Einddatum en tijd:</label>
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
     
      
       
   </div>
   
@endsection