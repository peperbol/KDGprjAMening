@extends('layouts.app')

@section('title', 'Reacties overzicht')

@section('content')
   
   <div class="variable_content">
      
      <div class="pageContent">
          
           <h1>Reacties overzicht</h1>
       
           @foreach ($comments_overview as $comments_block)
           <div>
               <h2>Project: {{ $comments_block[0]->name }}</h2>
               <div>
                   <h3>Comments</h3>
                   @foreach ($comments_block[1] as $comment)
                   <div>{{$comment->comment}}</div>
                   <div>Posted by: {{ $comment->name }}</div>
                   @endforeach
               </div>
           </div>
           @endforeach
          
      </div>
       
       
       
       
       
   </div>
   
@endsection