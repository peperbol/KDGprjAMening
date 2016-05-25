



(function() {
    
    var site = angular.module('antwerpen',[]);

    
    site.controller("ProjectController", ['$scope', '$http', function($scope, $http) {
        
        
        $scope.projectId;
        
        $scope.project_Name;
        $scope.project_Description;
        $scope.project_Startdate;
        $scope.project_Imagepath;
        
        
        $scope.timelineArray = [];
        
        $scope.dateObject = [];
        $scope.date;
        $scope.time;
        
        
        $scope.questionsPhase = [];
        
        
        
        var faseWithNr;
        $scope.first_comment;
        $scope.first_comment_shown = false;
        $scope.extra_comments_shown = false;
        $scope.button_show_more_shown = false;
        $scope.button_show_more_text = "TOON MEER";
        
        
        $scope.allQuestionsFilledIn = true;
        
        
        
        /*FUNCTIES*/
        $scope.Show_project_info;
        $scope.Show_timeline;
        $scope.Show_fase_info;
        $scope.Show_fase_comments;
        $scope.Show_phase_questions;
        
        
    
        
        $scope.questionsPhase = [];
        
        
        
        $scope.current_Fase_Name;
        $scope.current_Fase_description;
        $scope.current_Fase_enddate;
        $scope.current_Fase_imagepath;
        
        
        
        
        
  
        
        
        
        
        
    
        /**** FUNCTIONS  *****/
        
        
        /***  gets  ****/

        
        /*je klikt op een project en de project info wordt getoond + de tijdslijn van het project*/
        $scope.Show_project_info = function(){
            
            
            /*project info ophalen en in html elementen plaatsen*/
            $.getJSON( "project_2_info.json", function( data ) {

                //console.log(data);
                
                $scope.project_Name = data.name;
                $scope.project_Description = data.description;
                $scope.project_Startdate = data.startdate;
                $scope.project_Imagepath = data.imagepath;
                
                $scope.$apply();

            });
            
            
            $scope.Show_timeline();
        
            
        };//einde functie Show_project_info
        
        
        
        
        
        
        
        $scope.Show_timeline = function(){
            
            
            /*project fases ophalen en tellen hoeveel elementen er in de array zitten*/
            $.getJSON( "project_2_fases.json", function( data ) {
                
                
                /*aanmaken extra onderdeel object fase --> "Fase 1" bv*/
                for(i=1; i<=data.length; i++) {
                    
                    data[i-1].faseWithNr = "Fase " + i;
                    
                }
                
                
                /*binnenkoment object data is aangepast met string "Fase nr" bij te voegen*/
                $scope.timelineArray = data;
                
                $scope.timelineArray.reverse();
                
                $scope.$apply();

                
            });
            
             
        
        };//einde functie Show_timeline
        
        
        
        
        
    /***************************************************************************************************************************/ 
        
        
        
        
        /*Als op fase in tijdslijn klikt, de fase info + comments te zien krijgen*/
        $scope.Show_fase_info = function(phase_id){
            
            //console.log(fase_id);
            
            
            
            
            $.getJSON( "fase_2_info.json", function( data ) {
                
                console.log(data);
                
                $scope.current_Fase_Name = data[0].name;
                $scope.current_Fase_description = data[0].description;
                $scope.current_Fase_enddate = data[0].enddate;
                $scope.current_Fase_imagepath = data[0].imagepath;
                
                
                /*If phase is the most recent phase, show questions*/
                if(data.is_current) {
                    
                    $scope.Show_phase_questions(phase_id);
                    
                }
                
                
                $scope.$apply();
                
            });
            
            
            $scope.Show_fase_comments(phase_id);
            
            $scope.button_show_more_shown = true;
            
            $scope.button_show_more_text = "TOON MEER";
            
            $scope.extra_comments_shown = false;
            
            
            
        };//einde functie Show_fase_info
        
        
        
        
        

        
        
        
        
        
        
        $scope.Show_phase_questions = function(phase_id){
            
            
            $.getJSON( "questions_phase.json", function( data ) {
                        
                
                    /*create new object answer for each question --> fill in when form is submitted*/
                    for(i=0; i<data.length; i++) {
                        
                        data[i].answer= " ";
                        
                    };
                
                
                    $scope.questionsPhase = data;
                
                    $scope.$apply(); 
                     
                
            });
            
        };
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        $scope.Show_fase_comments = function(fase_id){
            
            
            $.getJSON( "comments_2.json", function( data ) {
                
                
                $scope.commentsArray = data;
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
                
                //console.log($scope.commentsArray);
                
                
                
                
                
                
                /*De eerste (nieuwste) comment er uit halen om altijd te tonen, blijft nog een array met de andere comments*/
                $scope.first_comment = $scope.commentsArray.shift();
                
                /*ook al is er nog niks om in te vullen, hij gaat de tekst "Bericht geplaatst:" al tonen, daarom hiden en showen wanneer we willen*/
                $scope.first_comment_shown = true;
                
                $scope.$apply();
                
            });
            
            
        };//einde functie Show_fase_comments
        
        
        
        
    /******************************************************************************************************************************/
        
        
        
        
        
        
        $scope.Show_extra_comments = function(){
            
            
            if($scope.button_show_more_text == "TOON MEER") {
                
                $scope.extra_comments_shown = true;
                $scope.button_show_more_text = "TOON MINDER";
                
            }
            
            
            else if($scope.button_show_more_text == "TOON MINDER") {
                
                $scope.extra_comments_shown = false;
                $scope.button_show_more_text = "TOON MEER";
                
            }
            
            
        };
        
        
        
        
        
        
        /**** POST ****/
        
        
        /*When form questions/comment is submitted, post answer each question + post comment of fase*/
        $scope.SendAnswer = function(){
            
            /*check if each question has been filled in*/
            for(i=0; i<$scope.questionsPhase.length; i++){
                
                
                /*if he finds an answer that still has the original value of " " --> change value true to false*/
                if($scope.questionsPhase[i].answer == " ") {
                
                    $scope.allQuestionsFilledIn = false;
                    
                };
            
                
            };
            
            
            /*has found no answer that is empty*/
            if($scope.allQuestionsFilledIn) {
                
                
                /*post each answer per iteration*/
                for(i=0; i<$scope.questionsPhase.length; i++){

                    console.log($scope.questionsPhase[i].id_question, $scope.questionsPhase[i].answer);

                };
                
                
            }
            
            
            $scope.SendComment();
            
            
        };
        
        
        
        $scope.SendComment = function(){
            
            
            console.log($scope.comment);
            /*post comment for phase*/
            
            
        };
        

        
        
        
        
    }]); //einde ProjectController
    
    
    
})(); //einde module
    
    
