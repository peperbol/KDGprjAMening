@extends('layouts.app')

@section('title', 'Fase bewerken')

@section('content')
   
   <div class="variable_content">
       
       <div class="pageContent">
           
       
           <form class="edit_event_form" action="{{ url('update_event') }}" method="POST" enctype="multipart/form-data">
               {{ csrf_field() }}
               
               <h3 class="title">Evenement "{{ $event->name }}" aanpassen</h3>
               
               <div>
                   <label for="name">Naam:</label>
                   <input id="name" name="name" type="text" value="{{ $event->name }}">
               </div>

               <div>
                   <label for="description">Beschrijving:</label>
                   <textarea id="description" name="description">{{ $event->description }}</textarea>
               </div>

               <div>
                   <label for="startdate">Startdatum:</label>
                   <input id="startdate" name="startdate" type="date" required value="{{$startdate_arr[0]}}">
                   <input id="starttime" name="starttime" type="time" required value="{{$startdate_arr[1]}}">
               </div>

               <div>
                   <label for="enddate">Einddatum:</label>
                   <input id="enddate" name="enddate" type="date" required value="{{$enddate_arr[0]}}">
                   <input id="endtime" name="endtime" type="time" required value="{{$enddate_arr[1]}}">
               </div>

               <div>
                   <label for="image">Afbeelding:</label>
                   <input type="file" name="image" id="image" name="image">
               </div>

               <div>
                   <input type="number" name="id_event" value="{{ $event->id_event }}" hidden>
               </div>

               <div>
                    <button type="submit">
                        Aanpassen
                    </button>
               </div>

           </form>
           
       </div>
       
       
       
   </div>
   
@endsection