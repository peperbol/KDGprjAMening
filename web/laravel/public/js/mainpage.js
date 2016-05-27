(function() {
    
    var site = angular.module('antwerpen',[]);

    
    site.controller("ProjectController", ['$scope', '$http', function($scope, $http) {
        
        $scope.projectId;
        
        $scope.project_Name;
        $scope.project_Description;
        $scope.project_Startdate;
        $scope.project_Imagepath;
        
        
        $scope.timelineArray = [];
        
        $scope.phase_selected;
        $scope.project_selected;
        
        $scope.dateObject = [];
        $scope.date;
        $scope.time;
        
        
        $scope.questionsPhase = [];
        
        var faseWithNr;
        var id_question;
        var answer;
        var commentPhase;
        var phase_id;
        
        
        var submit_success = true;
        $scope.first_comment;
        $scope.first_comment_shown = false;
        $scope.extra_comments_shown = false;
        $scope.button_show_more_shown = false;
        $scope.form_questions_shown = false;
        $scope.button_show_more_text = "TOON MEER";
        
        
        $scope.allQuestionsFilledIn = true;
        
        
        /*FUNCTIES*/
        $scope.Show_project_info;
        $scope.Show_timeline;
        $scope.Show_fase_info;
        $scope.Show_fase_comments;
        $scope.Show_phase_questions;
        $scope.Phase_selected;
        $scope.Project_selected;

        
        

        $scope.current_Fase_Name;
        $scope.current_Fase_description;
        $scope.current_Fase_enddate;
        $scope.current_Fase_imagepath;
        
        
        
        
        
        
        
        /***  GETS  ****/
        
        /*show project info along with latest phase info and current question*/
        $scope.Show_project_info = function(id){
            
            
            $scope.project_selected = id;
            
            
            $(".submit_confirmation").empty();
            
            $scope.current_Fase_Name = "";
            $scope.current_Fase_description = "";
            $scope.current_Fase_enddate = "";
            $scope.current_Fase_imagepath = "";
            
            //console.log(id);
            /*get project info and put into variables*/
            $.getJSON( "./get_project_info/"+id, function( data ) {

                //console.log(data);
                
                $scope.project_Name = data.name;
                $scope.project_Description = data.description;
                $scope.project_Startdate = data.startdate;
                $scope.project_Imagepath = data.imagepath;
                
                $scope.$apply();
                

            });
            
            $scope.Show_timeline(id);
        
        };//end function show
        
        
        $scope.Show_timeline = function(id){
            
            /*get project phases and count the amount of phases for this project*/
            $.getJSON( "./get_phases_project/" + id, function( data ) {
                
                /*aanmaken extra onderdeel object fase --> "Fase 1" bv*/
                for(i=1; i<=data.length; i++) {
                    data[i-1].faseWithNr = i;
                }
                
                
                /*binnenkoment object data is aangepast met string "Fase nr" bij te voegen*/
                $scope.timelineArray = data;
                
                $scope.timelineArray.reverse();
                
                
                $scope.phase_selected = $scope.timelineArray[0].faseWithNr;
                
                console.log($scope.phase_selected);
                
                $scope.Show_fase_info($scope.timelineArray[0].id_project_phase, $scope.phase_selected);
                
                $scope.$apply();

                
            });
            
             
        
        };//einde functie Show_timeline
        
        
        
        
    /***************************************************************************************************************************/ 
        
        
        /*Als op fase in tijdslijn klikt, de fase info + comments te zien krijgen*/
        $scope.Show_fase_info = function(phase_id, phase_nr){
            
            
            $(".submit_confirmation").empty();
            
            $.getJSON( "./get_phase_info/" + phase_id, function( data ) {
                
                console.log(data);
                
                $scope.current_Fase_Name = data[0].name;
                $scope.current_Fase_description = data[0].description;
                $scope.current_Fase_enddate = data[0].enddate;
                $scope.current_Fase_imagepath = data[0].imagepath;
                
                /*If phase is the most recent phase, show questions*/
                if(data.is_current) {
                    
                    $scope.Show_phase_questions(phase_id);
                    
                    $scope.form_questions_shown = true;
                    
                }
                else {
                    $scope.form_questions_shown = false;
                }
                
                $scope.$apply();
                
            });
            
            $scope.phase_selected = phase_nr;
            
            
            
            $scope.Show_fase_comments(phase_id);
            
            $scope.extra_comments_shown = false;
            
        };//einde functie Show_fase_info
        
        
        $scope.Phase_selected = function (phase_nr) {
            return $scope.phase_selected === phase_nr;
        }
        
        
        
        $scope.Project_selected = function (project_id) {
            return $scope.project_selected === project_id;
        }
        
        
        
        
        $scope.Show_phase_questions = function(phase_id){
            
            $scope.questionsPhase = [];
            
            $.getJSON( "./get_questions_phase/" + phase_id, function( data ) {
                //console.log(phase_id);
                //console.log(data[1]);
                    /*create new object answer for each question --> fill in when form is submitted*/
                    for(i=0; i<data[1].length; i++) {
                        //console.log(i);
                        data[1][i].answer= " ";
                        
                    };
                    
                    
                
                    $scope.questionsPhase = data[1];
                
                    $scope.$apply(); 
                     
                
            });
            
        };
        
        
        
        
        $scope.Show_fase_comments = function(phase_id){
            
            
            
            $.getJSON( "./get_comments_phase/" + phase_id, function( data ) {
                
                $scope.commentsArray = data;
                
                console.log($scope.commentsArray.length);
                
                
                
                
                
                /*comments komen in volgorde toe --> 1ste is de oudste, moeten nieuwste bovenaan hebben*/
                $scope.commentsArray.reverse();
                
                /*apart object per comment met datum en tijd*/
                for(i = 0; i < $scope.commentsArray.length; i++) {
   
                    /*dateTime splitsen om date en time apart te krijgen*/
                    $scope.dateObject = $scope.commentsArray[i].created_at.split(" ");
                    
                    $scope.date = $scope.dateObject[0];
                    $scope.time= $scope.dateObject[1];
                    
                    /*enkel eerste 4 karakters uit tijd halen bv 12:01*/
                    $scope.time = $scope.time.substring(0,5);
                    
                    /*apart object per comment met datum en tijd*/
                    $scope.commentsArray[i].date = $scope.date;
                    $scope.commentsArray[i].time = $scope.time;
                    
                }
                
                console.log($scope.commentsArray.length);
                if($scope.commentsArray.length == 1) {
                    $scope.button_show_more_shown = false;
                }
                
                else if($scope.commentsArray.length == 0) {
                    $scope.first_comment_shown = false;
                }
                
                
                else {
                    $scope.first_comment_shown = true;
                    $scope.button_show_more_shown = true;
                    $scope.button_show_more_text = "TOON MEER";
                    
                }
                
                
                /*De eerste (nieuwste) comment er uit halen om altijd te tonen, blijft nog een array met de andere comments*/
                $scope.first_comment = $scope.commentsArray.shift();
                
            
                
                
                
                $scope.$apply();
                
            });
            
            
        };//einde functie Show_fase_comments
        
        
        
        
    /******************************************************************************************************************************/
        
        
        
        
        
        
        $scope.Show_extra_comments = function(){
            
            
            if($scope.commentsArray.length > 0){
                
            
                if($scope.button_show_more_text == "TOON MEER") {

                    $scope.extra_comments_shown = true;
                    $scope.button_show_more_text = "TOON MINDER";

                }


                else if($scope.button_show_more_text == "TOON MINDER") {

                    $scope.extra_comments_shown = false;
                    $scope.button_show_more_text = "TOON MEER";

                }
                
            }
            
            
            else {
                
                $scope.button_show_more_shown = false;
                
            }
            
            
        };
        
 
        
        
        
        /**** POST ****/
        
        
        /*When form questions/comment is submitted, post answer each question + post comment of fase*/
        $scope.SendAnswer = function(){
            
            /*check if each question has been filled in*/
            for(i=0; i<$scope.questionsPhase.length; i++){
                
                console.log($scope.questionsPhase[i].answer);
                /*if he finds an answer that still has the original value of " " --> change value true to false*/
                if($scope.questionsPhase[i].answer == " ") {
                    $scope.allQuestionsFilledIn = false;
                    break;
                }
                else {
                    $scope.allQuestionsFilledIn = true;
                }
            
                
            };
            
            
            /*has found no answer that is empty*/
            if($scope.allQuestionsFilledIn) {
                console.log("juist!!");
                submit_success = true;
                $(".submit_confirmation").empty();
                
                /*post each answer per iteration*/
                for(i=0; i<$scope.questionsPhase.length; i++){

                    //console.log($scope.questionsPhase[i].id_question, $scope.questionsPhase[i].answer);
                    
                    id_question = $scope.questionsPhase[i].id_question;
                    answer = $scope.questionsPhase[i].answer;
                    
                    $http.post('./post_answer', 
                        {
                        
                        question_id: id_question,
                        answer: answer,
                        age: 1,
                        gender_id: 1

                        })
                    
                        .success(function(response) {
                            console.log(response);
                            
                        })
                    
                        .error(function(response) {
                        console.log(response);
                        submit_success = false;
                    }); 
                    
                };
                
                console.log(submit_success);
                
                if(submit_success) {
                    $(".submit_confirmation").text("Bedankt voor uw inzending!");
                    $scope.questionForm.$setPristine();
                    document.getElementById("questionForm").reset();
                }
                else {
                    $(".submit_confirmation").empty();
                    $(".submit_confirmation").text("Sorry er ging iets mis. Probeer opnieuw!");
                }
                
               
                $scope.SendComment();
            }
            
            /*not all Questions have been filled in --> show message*/
            else {
                
                $(".submit_confirmation").empty();
                $(".submit_confirmation").text("Niet alle vragen waren ingevuld. Vul alles in en probeer opnieuw.");
            };
            
            
            
            
            
        };
        
        
        
        $scope.SendComment = function(){
            
            
            console.log($scope.comment);
            
            commentPhase = $scope.comment;
            phase_id = $scope.questionsPhase[0].project_phase_id;
            
            /*post comment for phase*/
            
            if(commentPhase != undefined) { 
            
                $http.post('./post_comment', 
                            {

                            project_phase_id : phase_id,
                            age: 1,
                            gender_id: 1, 
                            comment: commentPhase

                            })

                            .success(function(response) {
                            console.log(response);
                            })

                            .error(function(response) {
                            console.log(response);
                        });
                
                $scope.Show_fase_comments(phase_id);
                $scope.apply();
                
            }//end if
        };

        
        
        
        
    }]); //einde ProjectController
    
    
    
})(); //einde module
    
    
