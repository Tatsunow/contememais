<?php
require_once "app/init.php";
$user = new Usuario();
if($user->isLogged()){
header("Location: /");   
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login no Conte-me mais</title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/signin.css"/>
<meta name="keywords" content="Contememais, Conte-me mais.com, contememais.com, www.contemem, conte tatsunow, mais, tatsunow, contemem"/>
<meta name="description" content="Conte-me mais é uma rede social bem legal baseada no facebook!"/>
<script src="js/signin.js"></script>
</head>
<body>
<div class="login">
<div class="header">
Login no Conte-me mais
</div>
<div class="fo">
<input type="text" id="email" name="email" placeholder="Email"/><br />
<input type="password" id="senha" name="senha" onkeypress="verifica(event);" placeholder="Senha"/><br />
<button type="submit" id="submitbtn" onclick="tentaLogar(event);">Login &#10140;</button><br />
<div id="msg" style="display: none;">Conte-me mais!</div>
</div>
</div>
</body>
</html>