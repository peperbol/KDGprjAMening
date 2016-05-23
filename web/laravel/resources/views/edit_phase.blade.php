@extends('layouts.app')

@section('title', 'Fase bewerken')

@section('content')
   
   <div class="variabele_content">
       
       <div class="pageContent">
       
           

           <form class="edit_phase_form" action="{{ url('update_phase') }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               
               <h3 class="title">Fase "{{ $phase->name }}" aanpassen</h3>
               
               <div>
                   <label for="name">Naam:</label>
                   <input id="name" name="name" type="text" value="{{ $phase->name }}">
               </div>

               <div>
                   <label for="description">Beschrijving:</label>
                   <textarea id="description" name="description">{{ $phase->description }}</textarea>
               </div>

               <div>
                   <label for="enddate">Einddatum:</label>
                   <input id="enddate" name="enddate" type="date" value="{{ $phase->enddate }}">
               </div>

               <div>
                   <label for="image">Afbeelding:</label>
                   <input type="file" name="image" id="image" name="image">
               </div>

               <div>
                   <input type="number" name="id_phase" value="{{ $phase->id_project_phase }}" hidden>
               </div>

               <div>
                    <button type="submit">
                        Aanpassen
                    </button>
               </div>

          
            <div class="add_question">
               <a href="{{ route('add_question', [$phase->id_project_phase]) }}">Vraag toevoegen</a>
            </div>
          
           </form>

           
       
       </div>
       
   </div>
   
@endsection