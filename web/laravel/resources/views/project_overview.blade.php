@extends('layouts.app')

@section('title', 'Project overview')

@section('content')
   
   <div class="temp_content">
       Hierin komt de veranderlijke content.
       Voor deze pagina zal dat dus een overzicht met de projecten zijn
       @foreach ($projects as $project)
           {{ $project->name }}
       @endforeach
   </div>
   
@endsection