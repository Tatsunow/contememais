function getEmoImg(){
return [
'anjo.PNG,O:)', 
'bjo.PNG,:*', 
'chorando.PNG,;(', 
'dunderstand.PNG,:?',
'gargalhada.PNG,:D', 
'grandesorriso.PNG,=D', 
'triste.PNG,:(', 
'sorriso.PNG,:)', 
'piscada.PNG,;)',
'malicia.PNG,(vergonha)',
'raivoso.PNG,>_<',
'surpreso.PNG,:O',
'semsorriso.PNG,:|',
'malicia.PNG,(demon)',
'medo.PNG,(medo)',
'legal.PNG,(cool)',
'turmindo.PNG,(zzz)',
'skol.PNG,(sk)',
'heart.PNG,<3',
'soco.PNG,(m)',
'beer.PNG,(beer)'
];
}
var div = document.getElementById("liste");
var images = "";
for(var i = 0; i<getEmoImg().length; i++){
images = images.concat("<img draggable='false' class='emo' title='" + getEmoImg()[i].split(",")[1] + "' data-target='" + getEmoImg()[i].split(",")[1] + "' style='width: 20px; cursor: pointer;' src='media/images/emoticons/" + getEmoImg()[i].split(",")[0] + "'/>");
}
div.innerHTML = div.innerHTML + "<br />" + images;
$("#emoticon").click(function(){
if(div.style.display == "block"){
div.style.display = "none";
} else {
div.style.display = "block";
}
});
$(".emo").click(function(){
var msg = document.getElementById('msg');
msg.value = msg.value + " " + event.target.dataset['target'];
});