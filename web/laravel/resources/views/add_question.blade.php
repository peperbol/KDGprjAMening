@extends('layouts.app')

@section('title', 'Vragen toevoegen')

@section('content')
   
   <div class="temp_content">
      <h1>Vragen toevoegen aan {{ $phase[0]->name }}</h1>
       
       
       <form action="" method="POST" >
           {{ csrf_field() }}
           <div>
               <label for="name">Vraag:</label>
               <input id="name" name="name" type="text" required>
           </div>
           
           <div>
               <label for="leftlabel">Optie 1:</label>
               <input id="leftlabel" name="leftlabel" type="text" required>
           </div>
           
           <div>
               <label for="rightlabel">Optie 2:</label>
               <input id="rightlabel" name="rightlabel" type="text">
           </div>
           
           
           
           <input type="number" id="phase" name="id_phase" value="{{ $phase[0]->id_project_phase }}" hidden>
           
           
           
           <div>
                <button type="submit">
                    Toevoegen
                </button>
           </div>
           
       </form>
       
   </div>
   
@endsection