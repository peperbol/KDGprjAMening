(function() {
    
    var site = angular.module('antwerpen',[]);

    
    site.controller("ProjectController", ['$scope', '$http', function($scope, $http) {
        
        var projectData = this;
        
        $scope.projectId;
        
        $scope.project_Name;
        $scope.project_Description;
        $scope.project_Startdate;
        $scope.project_Imagepath;
        
        var fasesProject;
        
        $scope.questionsPhase = [];
        
        $scope.Show_project_info;
        
        $scope.current_Fase_Name;
        $scope.current_Fase_description;
        $scope.current_Fase_enddate;
        $scope.current_Fase_imagepath;
        
        
        
        /***  GETS  ****/
        
        /*je klikt op een project en de project info wordt getoond, samen met de laatste fase en zijn vragen*/
        $scope.Show_project_info = function(id){
            
            //console.log(id);
            /*project info ophalen en in html elementen plaatsen*/
            $.getJSON( "./get_project_info/"+id, function( data ) {

                //console.log(data);
                
                $scope.project_Name = data.name;
                $scope.project_Description = data.description;
                $scope.project_Startdate = data.startdate;
                $scope.project_Imagepath = data.imagepath;
                
                $scope.$apply();
                

            });
            
        
        };//einde functie Show
        
        
        
 
        
        
        
        
        
    }]); //einde ProjectController
    
    
    
})(); //einde module
    
    
