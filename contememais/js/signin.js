function tentaLogar(event){
var email = document.getElementById("email");
var senha = document.getElementById("senha");
var msg = document.getElementById("msg");
var request = new XMLHttpRequest();
request.open("GET", "requests.php?request=login&email=" + email.value + "&senha=" + senha.value, true);
request.send(null);
event.target.innerHTML = "Logando <img src='http://loadinggif.com/images/image-selection/32.gif' style='width: 17px;'/>";
request.onloadend = function(){
event.target.innerHTML = "Login &#10140;";
};
request.onreadystatechange = function(){
if(request.readyState == 4){
var was = request.responseText == "true";
if(was){
msg.style.display = "block";
msg.style.opacity = "1";
msg.style.transition = "all 1s";
msg.innerHTML = "<font color='#00FF6E'>Você efetuou o login com sucesso, redirecionando...</font>";
setTimeout(function(){
document.location.href = "/";
},1000);
} else {
msg.style.display = "block";
msg.style.opacity = "1";
msg.style.transition = "all 1s";
msg.innerHTML = "<font color='red'>Usuário ou senha incorretos!</font>";
email.focus();
}
}
};
}
function click(target){
target.click();
}
function verifica(evt){
if(evt.keyCode == 13){
var btn = document.getElementById("submitbtn");
click(btn);
}
}