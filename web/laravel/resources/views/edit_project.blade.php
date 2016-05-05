@extends('layouts.app')

@section('title', 'Project bewerken')

@section('content')
   
   <div class="temp_content">
       Hierin kan je projecten aanpassen
       
       
       
       <form>
           
           <div>
               <label for="name">Naam:</label>
               <input id="name" type="text" value="{{ $project->name }}">
           </div>
           
           <div>
               <label for="description">Beschrijving:</label>
               <textarea id="description">{{ $project->description }}</textarea>
           </div>
           
           <div>
               <label for="startdate">Startdatum:</label>
               <input id="startdate" type="date" value="{{ $project->startdate }}">
           </div>
           
           <div>
               <label>Zichtbaar op site:</label>
               <!-- hier moet de checked one nog bepaald worden adhv de info uit de database -->
               <input id="ja" type="radio" name="hidden" value="0"><label for="ja">Ja</label>
               <input id="nee" type="radio" name="hidden" value="1"><label for="nee">Nee</label>
           </div>
           
           <div>
               <span>Aangemaakt door: {{ $user[0]->name }}</span>
           </div>
           
           
       </form>
       
       {{ $phases }}
       
       
       <div>
           <a href="{{ route('add_phase', [$project->id_project]) }}">Fase toevoegen</a>
       </div>
       
       
   </div>
   
@endsection