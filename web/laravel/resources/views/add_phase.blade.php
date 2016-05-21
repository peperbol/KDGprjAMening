@extends('layouts.app')

@section('content')
   
   <div class="temp_content">
      <h1>Fase toevoegen aan {{ $project->name }}</h1>
       
       
       <form action="{{ url('new_phase') }}" method="POST" enctype="multipart/form-data">
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
               <label for="enddate">Einddatum:</label>
               <input id="enddate" name="enddate" type="date" required>
           </div>
           
           <!-- Wordt bepaald op basis van de einddatum -->
           <!--
           <div>
               <label for="order">Volgorde:</label>
               <input id="order" name="order" type="number">
           </div>
           -->
           
           <div>
               <label for="image">Afbeelding:</label>
               <input type="file" id="image" name="image" required>
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