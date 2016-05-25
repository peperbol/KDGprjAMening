<!DOCTYPE html>
<html lang="en" ng-app="antwerpen">
    <head>
        <title>A-Mening projecten</title>

        <!-- CSS And JavaScript -->
        
        <!--<link href="css/style.css" rel="stylesheet">-->
        <!-- moet op onderstaande manier zodat de css accessible is in alle views-->
        <link href="{{ asset('css/homepage_style.css') }}" rel="stylesheet" type="text/css" >
    </head>

    <body ng-controller="ProjectController">
       
       <h1>A-Mening - projecten in Antwerpen</h1>
       
        <div class="left_box">
            
            <div class="map">

            </div>

            <div class="projects_list">
                <!-- hierin komt een lijst met alle projecten -->
                <ul>
                    @foreach($projects as $project)
                        <li ng-click="Show_project_info({{$project->id_project}})">{{ $project->name }}</li>
                    @endforeach
                </ul>
                
            </div>
            
        </div>
        
        <div class="right_box">
            <h3>@{{project_Name}}</h3>
            <p>@{{project_Description}}</p>
            <p>@{{project_Startdate}}</p>
            <!--<img src="images/project_images/@{{project_Imagepath}}" alt="xx">-->
            
            <div ng-repeat="fase in timelineArray">
                  
                    <a ng-click="Show_fase_info(fase.id_project_phase)">@{{fase.faseWithNr}}</a>
                    
            </div>
            
            <h3>@{{current_Fase_Name}}</h3>
            <p>@{{current_Fase_description}}</p>
            <p>@{{current_Fase_enddate}}</p>
            
            <div ng-show="first_comment_shown">
                <p>@{{first_comment.comment}}</p>
                <p>Bericht geplaatst op @{{first_comment.date}} om @{{first_comment.time}}</p>
            </div>
            
            <div ng-repeat="comment in commentsArray">
                 
                <div ng-show="extra_comments_shown">
                    <p>@{{comment.comment}}</p>
                    <p>Bericht geplaatst op @{{comment.date}} om @{{comment.time}}</p>
                </div>
                    
            </div>
            
            <button ng-show="button_show_more_shown" ng-click="Show_extra_comments()">@{{button_show_more_text}}</button>
            
        </div>
        
        <!--
        <div ng-controller="projController as proj">
            <form ng-submit="proj.sendAnswer()">
                
                <input type="text" name="test" id="test" required ng-model="proj.inputje">
           
                   <button type="submit">toevoegen</button>
            </form>
        </div>
        -->
        
        <div class="testforauth">
            {{--@if(Auth::check())
            @else
            niet ingelogd
            @endif--}}
        </div>
        
    
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="{{ asset('js/mainpage.js') }}" type="text/javascript"></script>
    

    </body>
</html>




