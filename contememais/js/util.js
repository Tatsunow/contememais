function like(id, target){
var request = new XMLHttpRequest();
request.open("GET", "requests.php?request=likepost&id=" + id, true);
request.send(null);
request.onreadystatechange = function(){
if(request.readyState == 4){
var likes = parseInt(request.responseText.split(",")[0]);
var liked = target.innerHTML.split(" ")[0] != "Descurtir";
var wholikes = request.responseText.split(",")[1];
if(likes > 1){
if(liked){
target.innerHTML = "Descurtir (" + likes + " Curtidas) ";
} else {
target.innerHTML = "Curtir (" + likes + " Curtidas)";
}
} else {
if(liked){
target.innerHTML = "Descurtir (" + likes + " Curtida)";
} else {
target.innerHTML = "Curtir (" + likes + " Curtidas)";
}
}
target.title = wholikes;
$(document).ready(function(){
Tipped.remove(target);
Tipped.create(target);
Tipped.refresh(target);
});
}
}
}
function deleta(id){
var request = new XMLHttpRequest();
request.open("GET", "requests.php?request=deletepost&id=" + id, true);
request.send(null);
request.onreadystatechange = function(){
if(request.readyState == 4){
var ok = request.responseText == "true";
if(ok){
var div = document.getElementById("" + id + "");
div.style.opacity="0";
div.style.transition = "1s opacity";
setTimeout(function(){
div.outerHTML = "";
}, 1000);
}
}
}
}

function showFoto(uuid){
var request = new XMLHttpRequest();
request.open("GET", "requests.php?request=foto&uuid=" + uuid);
request.send(null);
request.onreadystatechange = function(){
if(request.readyState == 4){
var link = request.responseText;
show("<img class='fotodoperfil' src='" + link + "'/>");
}  
};
}
function writeon(element, string){
element.innerHTML = element.innerHTML + string;
}
function closeShowing(){
var div = document.getElementById("showarea");
div.style.display = "none";
}
function show(type){
var div = document.getElementById("showarea");
div.style.display = "block";
var writeable = div.getElementsByClassName("writeable")[0];
writeable.innerHTML = "";
writeon(writeable, type);
}
function share(uuid, id){
var b = confirm("Você realmente deseja compartilhar isto?");
if(b){
var request = new XMLHttpRequest();
request.open("GET", "requests.php?request=share&id=" + id, true);
request.send(null);
request.onreadystatechange = function(){
if(request.readyState == 4){
var msg = request.responseText;
alert(msg);
document.location.reload();
}
}
}
}
$(document).ready(function(){
 var shares = document.getElementsByTagName("a");
 for(var i = 0; i<shares.length; i++){
    if(shares[i].innerHTML == "Compartilhar"){
        var current = shares[i];
        current.onclick = function(){
        var c = event.target;
          var uuid = c.dataset['target'].split(",")[0];
          var id = c.dataset['target'].split(",")[1];
          share(uuid, id);
        };
    }
 }
 var images = document.getElementsByTagName("img");
 for(var i = 0; i<images.length; i++){
 var c = images[i];
 if(c.id == "profilephoto"){
 c.onclick = function(){
 var uuid = event.target.dataset['target'];
 showFoto("" + uuid);
 };
 }
 }
});
