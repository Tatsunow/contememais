<?php 
require_once "app/init.php";

$util = new util();

// envia msg
if(isset($_POST['nome'], $_POST['msg'])){

	$nome = $_POST['nome'];
	$msg = $_POST['msg'];
	
	if(!empty($nome) && !empty($msg)){
		
		$util->sendMessage($nome, $msg);
		
	}
	
}
?>
<html>
<head>
<title>Colégio Estadual de Jandaia do Sul</title>	
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div class="menu">
<ul>
	
	<li><a href="/cejs">C.E.J.S</a></li>
	<li><a href="galeria.php">Galeria</a></li>
	
</ul>
</div>
<div class="topico">
	
	<a href=''>C.E.J.S</a> - Horários	
	
</div>
<div class="main">
	
<!-- HORÁRIOS -->
<ul class="horario">
<h3>6º Ano A</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>

	<ul class="horario">
<h3>6º Ano B</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>7º Ano A</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>

<ul class="horario">
<h3>7º Ano B</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>8º Ano A</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>8º Ano B</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>9º Ano A</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>

<ul class="horario">
<h3>9º Ano B</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>1º Ano A</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>1º Ano B</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>2º Ano A</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>2º Ano B</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>3º Ano A</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	
<ul class="horario">
<h3>3º Ano B</h3>
<li>Segunda-Feira: Indefinido</li>
<li>Terça-Feira: Indefinido</li>
<li>Quarta-Feira: Indefinido</li>
<li>Quinta-Feira: Indefinido</li>
<li>Sexta-Feira: Indefinido</li>
</ul>
	

	
	
	
<!-- MENSAGENS -->
<div class="topico">
	
	<a href=''>C.E.J.S</a> - Mensagens	
	
</div>
<div class="mensagens">
<?php 

echo $util->getMessages();

?>
</div>
<div class="send">
Deixe sua mensagem:<br /><br />
<form method="POST" action="">
<input type="text" placeholder="Seu Nome" name="nome" required/><br /><br />
<textarea name="msg" placeholder="Sua Mensagem..." required></textarea><br /><br />
<input type="submit" value="Deixar Mensagem"/>
</form>
</div>
	</div>	
<!-- FOOTER -->
<br /><br /><br /><br /><br /><br />
<div class="footer">
<span class="credit">Software de Site por Thiago Dlugosz Moraes (Tatsunow)</span>
<span class="item">Redes Sociais</span>
<ul>
<li><a target="_blank" title="Facebook" href="https://www.facebook.com/colegioestadualjandaiadosul"><img src="http://icons.iconarchive.com/icons/sicons/flat-shadow-social/256/facebook-icon.png"/></a></li>
<li><a target="_blank" title="Youtube"><img src="http://wcdn2.dataknet.com/static/resources/icons/set111/1dec2448.png"/></a></li>
</ul>
</div>
</body>
</html>