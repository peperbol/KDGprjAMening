@extends('layouts.app')

@section('title', 'Fase bewerken')

@section('content')
   
   <div class="temp_content">
       Hierin kan je fases aanpassen
       
       <h1>Fase "{{ $phase[0]->name }}" aanpassen</h1>
       
       <form action="{{ url('update_phase') }}" method="POST" enctype="multipart/form-data">
           {{ csrf_field() }}
           <div>
               <label for="name">Naam:</label>
               <input id="name" name="name" type="text" value="{{ $phase[0]->name }}">
           </div>
           
           <div>
               <label for="description">Beschrijving:</label>
               <textarea id="description" name="description">{{ $phase[0]->description }}</textarea>
           </div>
           
           <div>
               <label for="enddate">Einddatum:</label>
               <input id="enddate" name="enddate" type="date" value="{{ $phase[0]->enddate }}">
           </div>
           
           <div>
               <label for="image">Afbeelding:</label>
               <input type="file" name="image" id="image" name="image">
           </div>
           
           <div>
               <input type="number" name="id_phase" value="{{ $phase[0]->id_project_phase }}" hidden>
           </div>
           
           <div>
                <button type="submit">
                    Aanpassen
                </button>
           </div>
           
       </form>
       
       <div>
           <a href="{{ route('add_question', [$phase[0]->id_project_phase]) }}">Vraag toevoegen</a>
       </div>
       
       
   </div>
   
@endsection