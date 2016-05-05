@extends('layouts.app')

@section('content')
   
   <div class="temp_content">
      <h1>Fase toevoegen aan {{ $project->name }}</h1>
       Hierin komt de veranderlijke content.
       Voor deze pagina zal dat dus een form zijn met alle velden om een nieuw fase aan te maken.
       (doorverwezen vanaf een bestaand project)
       
       <form method="post">
           
           <div>
               <label for="name">Naam:</label>
               <input id="name" name="name" type="text">
           </div>
           
           <div>
               <label for="description">Beschrijving:</label>
               <textarea id="description" name="description"></textarea>
           </div>
           
           <div>
               <label for="enddate">Einddatum:</label>
               <input id="enddate" name="enddate" type="date">
           </div>
           
           
           <div>
               <label for="image">Afbeelding:</label>
               <input type="file" id="image" name="image">
           </div>
           
       </form>
       
   </div>
   
@endsection