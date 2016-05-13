@extends('layouts.app')

@section('title', 'Project toevoegen')

@section('pageSpecificCSS')
    <link href="{{ asset('css/add_project.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
   
   <div class="temp_content">
       Hierin komt de veranderlijke content.
       Voor deze pagina zal dat dus een form zijn met alle velden om een nieuw project aan te maken.
       
       <form id="add_project_form" action="{{ url('new_project') }}" method="POST" enctype="multipart/form-data">
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
               <input type="file" id="image" name="image">
           </div>
           
           <!-- google maps met marker om locatie toe te voegen (dus met coördinaten ipv adres ) -->
           <div>
               <label for="place-input">Locatie (zoek een adres om de marker op de kaart te krijgen):</label>
               <!-- onderstaande input moet normaal dan de street ofzo zijn (ofwel laat ik die ook helemaal vallen) -->
               <input id="place-input" class="controls" type="text" placeholder="Search Box" name="street">
               <div id="map"></div>
               <!--<div id="current">Nothing yet...</div>-->
           </div>
           
           <div>
               <label for="latitude">Latitude:</label>
               <input id="latitude" name="latitude" type="text" required>
           </div>
           
           <div>
               <label for="longitude">Longitude:</label>
               <input id="longitude" name="longitude" type="text" required>
           </div>
           
           <div>
               <label for="user">Aangemaakt door:</label>
               <!-- User X hieronder moet dynamisch ingevuld worden, navenant welke user ingelogd is -->
               <input type="text" id="user" name="user" value="User X" readonly>
           </div>
           
           
           <div class="">
                <button type="submit">
                    Toevoegen
                </button>
           </div>
           
       </form>
       
       
       <div>
           Hier moet ook nog ineens een form komen om direct een nieuwe fase toe te voegen.
           Dit kunnen we misschien best doen met een @ section van een andere blade, aangezien we dit toch ook nog nodig hebben op de aparte pagina "fase toevoegen".
           Als we dit met een @ section doen, vermijden we dus dubbele code (of gaan we dit met angular doen??)
       </div>
       
   </div>
   
@endsection




@section('pageSpecificJavascript')

    <script src="{{ asset('js/add_project_map.js') }}" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places&callback=initAutocomplete"
         async defer></script>
@endsection



