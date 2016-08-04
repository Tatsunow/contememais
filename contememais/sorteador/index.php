<html>
<head>
<title>Titl</title>
<style>
body {
background: #eaeaea;
font-family: "Trebuchet MS";
color: #202020;
text-align: center;
}	
#lista {
border: 1px solid;
border-color: #ddd #ddd #ccc;
border-radius: 3px;
background: #fff;
font-family: "Trebuchet MS";
resize: none;
}
#btn {
background: #fff;
color: #202020;
border: 1px solid;
border-radius: 3px;
border-color: #ddd #ddd #ccc;
padding: 15px;
padding-right: 50px;
padding-left: 50px;
transition: all 1s;
-moz-transition: all 1s;
-o-transition: all 1s;
-ms-transition: all 1s;
}
#btn:hover {
background: #eee;
cursor: pointer;
box-shadow: 1px 0px 10px 1px #202020;
transition: all 1s;
-moz-transition: all 1s;
-o-transition: all 1s;
-ms-transition: all 1s;
}
</style>
</head>
<body>
<script>
function getRandomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
function verifica(){
var lista = document.getElementById("lista");
lista.value = lista.value;
}
function sorteia(){
var lista = document.getElementById("lista");
var val = lista.value.split("\n");
var myl = val.length;
alert("Valor da lista sorteado: " + val[getRandomInt(0, myl)]);
}
</script>
<h1>Sorteador de Listas</h1>
<textarea id="lista" placeholder="Cole sua lista aqui" style="width: 700px; height: 550px;" onkeyup="verifica();"></textarea>
<br /><button id="btn" onclick="sorteia();">
	Sortear
	</button>
</form>	
</body>
</html>