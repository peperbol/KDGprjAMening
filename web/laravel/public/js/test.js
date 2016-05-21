//console.log("test");
/*
$.getJSON( "http://petrichor.multimediatechnology.be/api_project_info/2", function( data ) {
  console.log(data);
    $(".right_box").text(data.name);
});
*/

(function(){

    var app = angular.module('antwerpenApp', []);

    app.controller('projController', function($scope, $http) {

        var contr = this;
        
     contr.sendAnswer = function() {
         console.log(contr.inputje);
         
         
          //add data
          $http.post('./post_test', 
          {
            email: "test@test.com",
            text: contr.inputje

          })
          .success(function(response) {
            console.log(response);
          })
          .error(function(response) {
            console.log(response);
          });

        
        
        
        /*
            $http({
                method: 'POST',
                url: './post_test',
                data:  { task: 'do something', priority: 1 }
            });
         
         */
         
        };

    });
})();