@extends('layouts.app')

@section('title', 'Project overview')

@section('content')
   
   <div class="variable_content">
       <!--
       <ul class="project_list">
           @foreach ($projects as $project)
               <li>
                   <span class="name">{{ $project->name }}</span>
                   {{--<a href="{{ URL::route('/testje', $project->id_project) }}"> {{ $project->id_project }}</a>--}}
                   <a href="{{ route('edit_project', [$project->id_project]) }}">Bewerken</a>
                   <a href="{{ route('get_results_project', [$project->id_project]) }}">results</a>
                   <a href="{{ route('get_comments_project', [$project->id_project]) }}">comments</a>
               </li>
           @endforeach
       </ul>
       -->
       
        <div class="pageContent">
           
           @foreach ($projects as $project)
            <div class="project">
                <!--<img src="" alt="">-->
                <a href="#" class="watched @if($project->hidden == 1)hide @endif">
                    a
                </a>
                <div class="projectnaam">
                    <a href="{{ route('edit_project', [$project->id_project]) }}">{{ $project->name }}</a></div>
                <div class="icons">
                    <a href="{{ route('get_comments_project', [$project->id_project]) }}">t</a>
                    <a href="{{ route('get_results_project', [$project->id_project]) }}">y</a>
                    <a href="{{ route('edit_project', [$project->id_project]) }}">o</a>
                </div>
                
            </div>
            @endforeach
        </div>
       
       
       
       
   </div>
   
@endsection