console.log("test");

$.getJSON( "http://petrichor.multimediatechnology.be/api_project_info/2", function( data ) {
  console.log(data);
    $(".right_box").text(data.name);
});

