var sidenav=document.querySelector(".popup1")
var clossidenav=document.querySelector(".close")
function show(){
    sidenav.style.left="0px"
}
function closee(){
    sidenav.style.left="-60%"
}


$('.message a').click(function(){
    $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
 });

  