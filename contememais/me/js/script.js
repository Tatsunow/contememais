$(document).ready(function(){
	
	$(window).scroll(function(){

  var src = $(window).scrollTop();
  if(src>=295){
   var menu = $(".menu")[0];
   menu.style.position = "fixed";
   menu.style.width = "100%"; 
   menu.style.marginTop = "0px";
   menu.style.top = "0";
   menu.style.padding = "13px";
   menu.style.opacity = "0.9";
  
   var lista = menu.getElementsByTagName("ul")[0];
   if($(".menu ul li.up")[0] != null){
	   
   } else {
	   lista.innerHTML = lista.innerHTML + "\n<li class='up'><a href='#'>Cima</a></li>";
   }
 
   } else {
    var menu = $(".menu")[0];
    menu.style.position = "initial";
	menu.style.width = "";
	menu.style.marginTop = "50px";
	menu.style.padding = "10px";
	menu.style.opacity = "1";
	 if($(".menu ul li.up")[0] != null){
	$(".menu ul li.up")[0].outerHTML = "";
	 }
  }

});
	
});