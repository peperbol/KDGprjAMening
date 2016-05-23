@extends('layouts.app')

@section('title', 'Project bewerken')

@section('pageSpecificCSS')
    <link href="{{ asset('css/add_project.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
   
   <div class="variable_content">
       <div class="pageContent">



           <form id="edit_project_form" action="{{ url('update_project') }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               
               <h3 class="title">Project "{{ $project->name }}" aanpassen</h3>
               
               <div>
                   <label for="name">Naam:</label>
                   <input id="name" name="name" type="text" required value="{{$project->name}}">
               </div>

               <div>
                   <label for="description">Beschrijving:</label>
                   <textarea id="description" name="description" required>{{ $project->description }}</textarea>
               </div>

               <div>
                   <label for="startdate">Startdatum:</label>
                   <input id="startdate" name="startdate" type="date" required value="{{ $project->startdate }}">
               </div>

               <div>
                   <input type="checkbox" name="hidden" id="hidden" value="1">
                   <label for="hidden">Verborgen zetten</label>
               </div>

               <!--
               <div>
                   <label for="street">Straat:</label>
                   <input id="street" name="street" type="text" required>
               </div>

               <div>
                   <label for="number">Nummer:</label>
                   <input id="number" name="number" type="number" required>
               </div>
               -->

               <div>
                   <!--<img src="{{asset('images/project_images/'.$project->imagepath)}}" alt="{{$project->imagepath}}">-->
                   <label for="image">Afbeelding:</label>
                   <input type="file" id="image" name="image">
               </div>

               <!-- google maps met marker om locatie toe te voegen (dus met coördinaten ipv adres ) -->
               <div>
                   <label for="place-input">Locatie (zoek een adres om de marker op de kaart te krijgen of versleep de marker):</label>
                   <!-- onderstaande input moet normaal dan de street ofzo zijn (ofwel laat ik die ook helemaal vallen) -->
                   <input id="place-input" class="controls" type="text" placeholder="Search Box" name="street">
                   <input name="street_old" type="text" value="{{ $project->street }}" hidden>
                   <div id="map"></div>
                   <!--<div id="current">Nothing yet...</div>-->
               </div>

              <!--
               <div>
                   <label for="latitude">Latitude:</label>
                   <input id="latitude" name="latitude" type="text" required value="{{ $project->latitude }}">
               </div>

               <div>
                   <label for="longitude">Longitude:</label>
                   <input id="longitude" name="longitude" type="text" required value="{{ $project->longitude }}">
               </div>
               -->
               
               <input id="latitude" name="latitude" type="text" required value="{{ $project->latitude }}" hidden>
               <input id="longitude" name="longitude" type="text" required value="{{ $project->longitude }}" hidden>

               <div>
                   <span>Aangemaakt door: {{ $user[0]->name }}</span>
                   <input type="number" name="user" value="{{ $user[0]->id }}" hidden>
               </div>

               <div>
                   <input type="number" name="id_project" value="{{ $project->id_project }}" hidden>
               </div>


               <div class="edit_button">
                    <button type="submit">
                        Aanpassen
                    </button>
               </div>


           </form>

          
          <div class="phases_and_events">
              

              <div class="phases">
                 
                 <h3 class="title">Fases</h3>
                 
                  @foreach($phases as $phase)
                       <div>
                           <div>{{ $phase->name }}</div>
                           <a href="{{ route('edit_phase', [$phase->id_project_phase]) }}">Bewerken</a>
                       </div>
                   @endforeach
              </div>
              
              
               <div class="events">
                   <h3 class="title">Events</h3>
                   
                   @foreach($events as $event)
                       <div>
                           <div>{{ $event->name }}</div>
                           <a href="{{ route('edit_event', [$event->id_event]) }}">Bewerken</a>
                       </div>
                   @endforeach
               </div>
               


               <div class="add_phases_events">
                   <a href="{{ route('add_phase', [$project->id_project]) }}">Fase toevoegen</a>
                   <a href="{{ route('add_event', [$project->id_project]) }}">Event toevoegen</a>
               </div>
          </div>
           
       
       </div>
   </div>
   
@endsection



@section('pageSpecificJavascript')

    <script src="{{ asset('js/edit_project_map.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete"
         async defer></script>
@endsection


