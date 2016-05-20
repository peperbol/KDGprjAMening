@extends('layouts.app')

@section('title', 'Vragen toevoegen')

@section('content')
   
   <div class="temp_content">
      <h1>Vragen toevoegen aan {{ $phase[0]->name }}</h1>
       
       
       <form action="{{ url('new_question') }}" method="POST" enctype="multipart/form-data">
           {{ csrf_field() }}
           <div>
               <label for="questiontext">Vraag:</label>
               <input id="questiontext" name="questiontext" type="text" required>
           </div>
           
           <div>
               <label for="leftlabel">Optie 1:</label>
               <input id="leftlabel" name="leftlabel" type="text" required>
           </div>
           
           <div>
               <label for="rightlabel">Optie 2:</label>
               <input id="rightlabel" name="rightlabel" type="text" required>
           </div>
           
           <div>
               <label for="left_picture_path">Afbeelding optie 1 (indien er maar 1 afbeelding is, gelieve deze hier te uploaden):</label>
               <input type="file" id="left_picture_path" name="left_picture_path" required>
           </div>
           
           <div>
               <label for="right_picture_path">Afbeelding optie 2:</label>
               <input type="file" id="right_picture_path" name="right_picture_path" required>
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