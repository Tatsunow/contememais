function showStatus(nome, status){
var div = document.createElement("DIV");
div.style.background = "red";
div.style.width = "300px";
div.style.height = "500px";
div.style.id = nome;
div.innerHTML = "Status de " + nome + ":" + status;
}