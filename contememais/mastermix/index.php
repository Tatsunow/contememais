<?php 
require_once "app/init.php"; 
$post = new post();
$url = "";
if(isset($_GET['post'])){
$pn = $_GET['post'];
$postag = $post->getPost($pn)['Nome'];
$url = "- $postag";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mastermix <?php echo $url; ?></title>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<div class="header">
<a href="/mastermix"><span class="name">Mastermixsom</span></a>
<div class="buttons">
<form method="GET" action="search.php">
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
<?php 
if(isset($_GET['post'])){
$pn = $_GET['post'];
$postag = $post->getPost($pn)['Nome'];
echo $postag;
} else {
echo "Mastermix som, o Som!!!";
}
?>
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
<?php
if(isset($_GET['categoria']) && !empty($_GET['categoria'])){
$cat = $_GET['categoria'];
$post->getPostsByCat($cat);
}
if(isset($_GET['post']) && !empty($_GET['post']) && !(isset($_GET['categoria']))){
$id = $_GET['post'];
$postagem = $post->getPost($id);
$nome = $postagem['Nome'];
$autor = $postagem['Autor'];
$postagemb = $postagem['Postagem'];
$cats = explode(",", $postagem['Categorias']);
$ctext;
if(count($cats) == 2){
$cat1 = $cats[0];
$cat2 = $cats[1];
$ctext = "<a href='/mastermix/?categoria=$cat1' class='blink' style='color: #00B7FF;'>$cat1</a> e <a href='/mastermix/?categoria=$cat2' class='blink' style='color: #00B7FF;'>$cat2</a>";   
} else{
foreach($cats as $row){
$ctext = $ctext . "<a class='blink' style='color: #00B7FF;' href='/mastermix/?categoria=$row'>" . $row . "</a> ";
}
}

?>
<div class="local">
<a href=""><span>Home</span></a> <span class='sy'>›</span> <a href="/mastermix/?post=<?php echo $id; ?>"><span class="atual"><?php echo $nome;?></span></a>
</div>
<h1><?php echo $nome; ?></h1>

<?php echo $postagemb;?>
<div class="autor">
Postado por: <?php echo $autor;?>
</div>
<div class="categorias">
Categorias: <?php echo $ctext; ?>
</div>
<?php
} else if(!isset($_GET['categoria'])){
echo "<h1>Todos os Posts: </h1><br />";
echo $post->getAllPosts();
}
?>
</div>
</div>
</body>
</html>