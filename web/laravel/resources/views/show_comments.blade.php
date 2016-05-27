@extends('layouts.app')

@section('title', 'Comments')

@section('pageSpecificCSS')
    <link href="{{ asset('css/comments_style.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
   
   <div class="variabele_content">
       <div class="pageContent">
          
          <!--
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
           -->
           
           <!-- Arteau's deel -->
           
           <div class="commentTopWrapper">
                    
                    <h2 class="title">{{$project->name}}</h2>
                    <div class="commentTable">
                       <div class="horizontalScroller">
                       @foreach ($comments_project as $comments_phase)
                        <div class="commentColumn">
                            <h3>Fase: {{ $comments_phase[0]->name }}</h3>
                            <div class="commentsColumnInside projectCommentaarOverride">
                               @foreach ($comments_phase[1] as $comment)
                               <div class="comment">
                                <a href="{{ route('delete_comment', [$comment->id_comment]) }}" class="deleteButton"></a>
                                <p>
                                 {{$comment->comment}}
                                </p>
                                <p class="dateLine">
                                    <span>Geplaatst op</span>
                                    <span class="textHighlight">{{$comment->created_at}}</span>
                                </p>
                                </div>
                                @endforeach
                                
                                
                            </div>
                        </div>
                       @endforeach
                        
                    </div>
                    </div>
                </div>
           
           
       
       </div>
       
   </div>
   
@endsection