<?php
if(isset($_POST['valor'])){
$valor = $_POST['valor'];
$salt = md5("Conte-me mais! - Social Network, desenvolvedor: Tatsunow");
        $codifica = hash("sha512", md5(base64_encode(md5(base64_encode($salt . base64_encode($hash) . $salt)))));
        $codifica = hash("sha512", $codifica);
echo $codifica;
}

?>
<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>
<form method="POST" action="">
<input type="text" name="valor" placeholder="Insira o texto aqui."/><br />
<input type="submit" value="Gerar"/>
</form>
</body>
</html>