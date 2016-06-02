@extends('layouts.app')

@section('title', 'Project toevoegen')

@section('pageSpecificCSS')
    <link href="{{ asset('css/add_project.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
   
   <div class="variable_content">
       
       <div class="pageContent">
           <form id="add_project_form" action="{{ url('new_project') }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}

               <h3 class="title">Project toevoegen</h3>

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
                   <label for="image">Afbeelding:</label>
                   <input type="file" id="image" name="image" required>
               </div>

               <!-- google maps met marker om locatie toe te voegen (dus met coördinaten ipv adres ) -->
               <div>
                   <label for="place-input">Locatie (zoek een adres om de marker op de kaart te krijgen):</label>
                   <!-- onderstaande input moet normaal dan de street ofzo zijn (ofwel laat ik die ook helemaal vallen) -->
                   <input id="place-input" class="controls" type="text" placeholder="Search Box" name="street">
                   <div id="map"></div>
                   <!--<div id="current">Nothing yet...</div>-->
               </div>

              <!--
               <div class="hide">
                   <label for="latitude">Latitude:</label>
                   <input id="latitude" name="latitude" type="text" required>
               </div>

               <div>
                   <label for="longitude">Longitude:</label>
                   <input id="longitude" name="longitude" type="text" required>
               </div>
               -->
               
               <input id="latitude" name="latitude" type="text" required hidden>
               <input id="longitude" name="longitude" type="text" required hidden>

               <div>
                   <label for="user">Aangemaakt door:</label>
                   <!-- User X hieronder moet dynamisch ingevuld worden, navenant welke user ingelogd is -->
                   <input type="text" id="user" name="username" value="{{Auth::user()->name}}" readonly>
                   <input type="number" id="user_id" name="user" value="{{Auth::user()->id}}" hidden>
               </div>


               <h3 class="title fase1">Fase 1</h3>


               <div>
                   <label for="phase_name">Naam:</label>
                   <input id="phase_name" name="phase_name" type="text" required>
               </div>

               <div>
                   <label for="phase_description">Beschrijving:</label>
                   <textarea id="phase_description" name="phase_description" required></textarea>
               </div>

               <div>
                   <label for="phase_enddate">Einddatum:</label>
                   <input id="phase_enddate" name="phase_enddate" type="date" required>
               </div>

               <div>
                   <label for="phase_image">Afbeelding:</label>
                   <input type="file" id="phase_image" name="phase_image" required>
               </div>



               <div class="add_button">
                    <button type="submit">
                        Project aanmaken
                    </button>
               </div>

           </form>
       
       
       
       
       
       
       </div>
       
   </div>
   
@endsection




@section('pageSpecificJavascript')

    <script src="{{ asset('js/add_project_map.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete"
         async defer></script>
@endsection



