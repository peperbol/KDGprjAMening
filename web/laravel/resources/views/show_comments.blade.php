@extends('layouts.app')

@section('title', 'Comments')

@section('content')
   
   <div class="temp_content">
       
       <h1>Comments</h1>
       
       @foreach ($comments_project as $comments_phase)
       <div>
           <h2>Fase: {{ $comments_phase[0]->name }}</h2>
           <div>
               <h3>Comments</h3>
               @foreach ($comments_phase[1] as $comment)
               <div>{{$comment->comment}}</div>
               @endforeach
           </div>
       </div>
       @endforeach
       
       
       
   </div>
   
@endsection