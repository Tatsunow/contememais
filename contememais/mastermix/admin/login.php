<?php
require_once "app/init.php";
$adm = new adm();
if($adm->isLogado()){
header("Location: /mastermix/admin/index.php");
return;
}
if(isset($_POST['autor'], $_POST['senha'])){
$autor = $_POST['autor'];
$senha = $_POST['senha'];
if(!empty($autor) && !empty($senha)){
$adm->loga($autor, $senha);
}
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Painel Administrador - Login</title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div class="login">
<div class="header">
Fazer o Login
</div>
<form method="POST" action="">
Autor:<br />
<select placeholder="Autor" name="autor">
<?php $adm->pegaAutores(); ?>
</select><br />Senha:<br />
<input type="password" name="senha" placeholder="Senha"/><br /><br />
<input type="submit" value="Fazer Login"/><br /><br />
<font color="red">
<?php 
if(isset($_SESSION['erro'])){
echo $_SESSION['erro'];
unset($_SESSION['erro']);
}
?>
</font>
</form>
</div>
</body>
</html>