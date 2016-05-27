@extends('layouts.app')

@section('title', 'Reacties overzicht')

@section('pageSpecificCSS')
    <link href="{{ asset('css/comments_style.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
   
   <div class="variable_content">
      
      <div class="pageContent reactiesOverride">
          
          <!--
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
           -->
          
          
          <div class="commentTopWrapper">
                    <div class="commentTable">
                       <div class="horizontalScroller">
                       @foreach ($comments_overview as $comments_block)
                        <div class="commentColumn">
                            <h2 class="title">{{ $comments_block[0]->name }}</h2>
                            <h3>Laatste fase</h3>
                            <div class="commentsColumnInside">
                              
                              @foreach ($comments_block[1] as $comment)
                               <div class="comment">
                                <a href="{{ route('delete_comment_from_overview', [$comment->id_comment]) }}" class="deleteButton"></a>
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