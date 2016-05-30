<!DOCTYPE html>
<html lang="nl" ng-app="antwerpen">
    <head>
        <title>A-Mening projecten</title>

        <!-- CSS And JavaScript -->

        <!--<link href="css/style.css" rel="stylesheet">-->
        <!-- moet op onderstaande manier zodat de css accessible is in alle views-->
        <!--<link href="{{ asset('css/homepage_style.css') }}" rel="stylesheet" type="text/css" >-->


        <meta charset="UTF-8">
        <title>A Mening</title>
        <link rel="stylesheet" href="https://opensource.keycdn.com/fontawesome/4.6.3/font-awesome.min.css ">
        <link rel="stylesheet" href="{{ asset('font/AntwerpenRegular/Antwerpen-Regular.css') }}">
        <link rel="stylesheet" href="{{ asset('font/AntwerpenSmallCaps/AntwerpenSmallCaps-Regular.css') }}">
        <link rel="stylesheet" href="{{ asset('font/AntwerpenTall/AntwerpenTall-Tall.css') }}">
        <link rel="stylesheet" href="{{ asset('font/SunAntwerpen/SunAntwerpen.css') }}">
        <link rel="stylesheet" href="{{ asset('css/mainpage.css') }}">
        <meta name="viewport" content="width=550">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/icon_images/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/icon_images/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/icon_images/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/icon_images/favicon-16x16.png') }}">

    </head>

    <body ng-controller="ProjectController" ng-init="Show_project_info({{$projects[0]->id_project}})">

       <!--
       <h1>A-Mening - projecten in Antwerpen</h1>

       <div>
           <img src="images/icon_images/Google_Play_logo.png" alt="test">
       </div>
        <div class="left_box">

            <div class="map">

            </div>

            <div class="projects_list">
                <!-- hierin komt een lijst met alle projecten --><!--
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
            <!--<img src="images/project_images/@{{project_Imagepath}}" alt="xx">--><!--

            <div ng-repeat="fase in timelineArray">

                    <a ng-click="Show_fase_info(fase.id_project_phase)">@{{fase.faseWithNr}}</a>

            </div>

            <h3>@{{current_Fase_Name}}</h3>
            <p>@{{current_Fase_description}}</p>
            <p>@{{current_Fase_enddate}}</p>




            <form name="questionForm" ng-submit="SendAnswer()" ng-show="form_questions_shown" novalidate>
                <div ng-repeat="question in questionsPhase">

                    <p>@{{question.questiontext}}</p>

                    <input type="radio" name="@{{question.id_question}}" ng-model="question.answer" value="0" id="answL@{{question.id_question}}">
                    <label for="answL@{{question.id_question}}">@{{question.leftlabel}}</label> <br>
                    <input type="radio" name="@{{question.id_question}}" ng-model="question.answer" value="1" id="answR@{{question.id_question}}">
                    <label for="answR@{{question.id_question}}">@{{question.rightlabel}} </label> <br>

                </div>

                    <textarea id="comment_sectie" name="commentFase" placeholder="Commentaar" ng-model="comment"></textarea>

                <button type="submit">STUUR IN</button>

            </form>



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
        <!--
        <div class="testforauth">
            {{--@if(Auth::check())
            @else
            niet ingelogd
            @endif--}}
        </div>
        -->

        <!-----------    Pepijn's deel        --------->

        <div class="leftSide">
            <a class="logo" href="https://www.antwerpen.be/nl/home">
              <img width="100%" heigth="100%" src="images/icon_images/logo.jpg">
            </a>
            <div id="map">

            </div>
            <input type="checkbox" id="hamburger" value="open">
            <label for="hamburger" class="projectList">
              <i class="fa fa-bars" aria-hidden="true"></i>
              <ul>
                    @foreach($projects as $project)
                        <li ng-click="Show_project_info({{$project->id_project}})" ng-class="{ 'selectedProject': Project_selected({{$project->id_project}}) }">
                          <div>
                            <div>
                               <img src="images/project_images/{{$project->imagepath}}">
                            </div>
                            <p>{{ $project->name }}</p>
                          </div>
                        </li>
                    @endforeach
                </ul>
            </label>
          </div>


        <!--    right side    -->

        <div class="rightSide">
            <div class="header" style="background-image: url('images/project_images/@{{current_Fase_imagepath}}');"></div>
            <div class="contentWrapper">
              <h2>@{{project_Name}}</h2>
              <p>@{{project_Description}}</p>

              <h3>@{{current_Fase_Name}}</h3>
              <p>@{{current_Fase_description}}</p>

             <form id="questionForm" name="questionForm" ng-submit="SendAnswer()" ng-show="form_questions_shown" novalidate>
                  <div class="choiceBoxContainer">

                   <!-- for each question an ul -->
                    <ul ng-repeat="question in questionsPhase">
                      <li class="choiceTitle">@{{question.questiontext}}</li>
                      <li class="choicePick activeChoice">
                        <input type="radio" name="@{{question.id_question}}" ng-model="question.answer" value="0" id="answL@{{question.id_question}}">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        <label for="answL@{{question.id_question}}">@{{question.leftlabel}}</label>
                      </li>
                      <li class="choicePick">
                        <input type="radio" name="@{{question.id_question}}" ng-model="question.answer" value="1" id="answR@{{question.id_question}}">
                        <i class="fa fa-check" aria-hidden="true"></i>
                        <label for="answR@{{question.id_question}}">@{{question.rightlabel}}</label>
                      </li>
                    </ul>

                  </div>

                  <textarea class="feedbackInput" name="commentFase" placeholder="Wij horen graag jouw mening!" ng-model="comment"></textarea>

                  <div class="submit_confirmation">
                      <p></p>
                  </div>

                  <button class="stuurIn" type="submit">STUUR IN</button>


              </form>



              <h3>Reacties</h3>
              <div class="comments">

                <div ng-show="first_comment_shown">
                  <p class="bodytext">
                    @{{first_comment.comment}}
                  </p>
                  <p>
                    <span>Bericht geplaatst op </span>
                    <span class="highlight">@{{first_comment.date}}</span>
                    <span> om </span>
                    <span class="highlight">@{{first_comment.time}}</span>
                  </p>
                </div>

                <div ng-repeat="comment in commentsArray">

                    <div ng-show="extra_comments_shown">
                        <p class="bodytext">
                            @{{comment.comment}}
                        </p>
                        <p>
                            <span>Bericht geplaatst op </span>
                            <span class="highlight">@{{comment.date}}</span>
                            <span> om </span>
                            <span class="highlight">@{{comment.time}}</span>
                        </p>
                    </div>

                </div>


              </div>
              <div class="center">
                <button class="morecomments" ng-show="button_show_more_shown" ng-click="Show_extra_comments()">@{{button_show_more_text}}</button>
              </div>

              <p ng-hide="first_comment_shown">Voorlopig zijn er nog geen reacties geplaatst.</p>

            </div>

          </div>



        <div class="timelineContainer">
            <ul class="timeline">


              <li ng-repeat="fase in timelineArray" ng-click="Show_fase_info(fase.id_project_phase, fase.faseWithNr)" ng-class="{ 'currentPhase': fase.faseWithNr!=timelineArray.length-1 , 'fase': fase.faseWithNr==timelineArray.length-1, 'active': Phase_selected(fase.faseWithNr)  }">
                <h2 class="faseHead">FASE</h2>
                <h2 class="faseHead">@{{fase.faseWithNr}}</h2>
                <p ng-show="fase.faseWithNr!=timelineArray.length-1">@{{fase.enddate}}</p>
              </li>

            </ul>

            <div class="fase playstore">
              <a href="https://play.google.com/store/apps/details?id=com.pepijnwillekens.kdg.amening">
                <img src="images/icon_images/Google_Play_logo3.png" alt="">
              </a>
            </div>
        </div>






    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtRQT9vIjQs-drmitlleXzqi5xgtYH3L8" async defer></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="{{ asset('js/mainpage.js') }}" type="text/javascript"></script>





    </body>
</html>
