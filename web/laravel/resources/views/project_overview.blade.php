@extends('layouts.app')

@section('title', 'Project overview')

@section('content')
   
   <div class="temp_content">
       Hierin komt de veranderlijke content.
       Voor deze pagina zal dat dus een overzicht met de projecten zijn

       {{--<ul>
           @foreach ($projects as $project)
               <li>{{ $project->name }} - {{ $project->event }}</li>
           @endforeach
       </ul>

       <ul>
           @foreach ($events as $event)
               <li>{{ $event->description }} - {{ $event->get_proj_name() }}</li>
           @endforeach
       </ul>--}}
       <!--<ul>
           
               <li><?php /*var_dump($projects->event[0]->name) */?></li>
       </ul>
       --}}-->
       
       <ul class="project_list">
           @foreach ($projects as $project)
               <li>
                   <span class="name">{{ $project->name }}</span>
                   <!--<div class="options">-->
                   {{--<a href="{{ URL::route('/testje', $project->id_project) }}"> {{ $project->id_project }}</a>--}}
                   <a href="{{ route('edit_project', [$project->id_project]) }}">Bewerken</a>
                   <a href="{{ route('get_results_project', [$project->id_project]) }}">results</a>
                   <a href="{{ route('get_comments_project', [$project->id_project]) }}">comments</a>
                   <!--</div>-->
               </li>
           @endforeach
       </ul>
       
       
   </div>
   
@endsection