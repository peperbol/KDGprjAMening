@extends('layouts.app')

@section('title', 'Resultaten')

@section('content')
   
   <div class="temp_content">
       
       <h1>Resultaten</h1>
       
       @foreach ($results_project as $results_phase)
       <div>
           <h2>Fase: {{ $results_phase[0]->name }}</h2>
           <div>
               <h3>Resultaten</h3>
               @foreach ($results_phase[1] as $result)
               <div class="question">{{$result[0]}}</div>
               <div>{{$result[1]}}: <span>{{$result[3]}}</span></div>
               <div>{{$result[2]}}: <span>{{$result[4]}}</span></div>
               @endforeach
           </div>
       </div>
       @endforeach
       
       
       
   </div>
   
@endsection