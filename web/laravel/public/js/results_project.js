console.log("test");


var left_procent = $(".procent.left").text();
var right_procent = $(".procent.right").text();

console.log(left_procent);

$(".statBar>div").width(left_procent + "%");