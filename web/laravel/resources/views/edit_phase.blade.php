@extends('layouts.app')

@section('title', 'Fase bewerken')

@section('content')
   
   <div class="temp_content">
       Hierin kan je fases aanpassen
       
       
       
       <form>
           
           <div>
               <label for="name">Naam:</label>
               <input id="name" type="text" value="{{ $phase[0]->name }}">
           </div>
           
           <div>
               <label for="description">Beschrijving:</label>
               <textarea id="description">{{ $phase[0]->description }}</textarea>
           </div>
           
           <div>
               <label for="enddate">Einddatum:</label>
               <input id="enddate" type="date" value="{{ $phase[0]->enddate }}">
           </div>
           
           
           
       </form>
       
       <div>
           <a href="{{ route('add_question', [$phase[0]->id_project_phase]) }}">Vraag toevoegen</a>
       </div>
       
       
   </div>
   
@endsection