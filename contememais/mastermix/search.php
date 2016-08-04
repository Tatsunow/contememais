<?php 
require_once "app/init.php"; 
$post = new post();
$query;
if(isset($_GET['query'])){
$query = $_GET['query'];
} else {
header("Location: /mastermix");
}
if(empty($query)){
header("Location: /mastermix");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mastermix - Pesquisa por <?php echo $query; ?></title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div class="header">
<a href="/mastermix"><span class="name">Mastermix som</span></a>
<div class="buttons">
<form method="GET" action="">
<input type="text" placeholder="O QUE VOCÊ PROCURA?" name="query" class="texto"/>
<input type="submit" value="Pesquisar"/>
</form>
</div>
<div class="links">
<a href="#">Facebook</a>
<li class="dot"></li>
<a href="#">Twitter</a>
<li class="dot"></li>
<a href="#">Youtube</a>
</div>
<div class="menu">
<a href="/mastermix">Mastermix</a>

</div>
<div class="bgto">
<div class="to">
Pesquisando por: <?php echo $query; ?>
</to>
</div>
</div>
<div class="geral">
<div class="leftItems">
<h3 class="fix">Categorias</h3>
<?php echo $post->getCategorias();?>
</div>
<br />
<div class="conteudo">
<div class="local">
<a href=""><span>Home</span></a> <span class='sy'>›</span> <a href="/mastermix/search.php"><span class="atual">Pesquisando</span></a>
</div>
<?php
$postag = $post->getSearch($query);
?>
</div>
</div>
</body>
</html>