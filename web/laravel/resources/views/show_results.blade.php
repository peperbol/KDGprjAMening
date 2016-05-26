@extends('layouts.app')

@section('title', 'Resultaten')

@section('content')
   
   <div class="variable_content">
       
       <!--
       <h1>Resultaten: {{$project->name}}</h1>
       
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
       -->
       
       <div class="pageContent">
           
           <div class="container_stat">
                    <h3 class="title">Resultaten: {{$project->name}}</h3>
                    <div name="projectStatForm" class="statContainer">
                      @foreach ($results_project as $results_phase)
                           <h3>Fase: {{ $results_phase[0]->name }}</h3>
                           @foreach ($results_phase[1] as $result)
                           <div class="insideStatContainer">
                               <p>{{$result[0]}}</p>
                               <!--
                               <div class="statBar">
                               <div></div>
                               </div>
                               -->
                               <div>
                                   <h4 class="h4Left">{{$result[1]}}</h4><h4  class="h4right">{{$result[2]}}</h4>
                               </div>
                                   <h4 class="leftStemmen stemmen">Stemmen: {{$result[3]}}</h4><h4 class="rightStemmen stemmen">Stemmen: {{$result[4]}}</h4>
                                   <div class="procent left">{{$result[5]}}</div><div class="procent right">{{$result[6]}}%</div>
                           </div>
                           @endforeach
                      @endforeach
                       
                       
                    </div>
                </div>
           
       </div>
       
       
       
   </div>
   
@endsection


@section('pageSpecificJavascript')

    <!--<script src="{{ asset('js/results_project.js') }}" type="text/javascript"></script>-->
@endsection



