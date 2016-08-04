<?php
require_once "fun/init.php";

$posts = new Posts();


$title;
if(isset($_GET['module'])){
    
    $module = $_GET['module'];
    if($module == "about"){
        
        $title = "- Sobre";
        
    }
    
    if($module == "post" && !isset($_GET['tag']) && isset($_GET['id'])) {
        
        $id = intval($_GET['id']);
        $post = $posts->getPostName($id);
        $title = "- " . $post;
        
    }
    
} else {
    $title = "- Inicio";
}

?>
<!DOCTYPE html>
<html>
<head>
    
    
<title>Thiago Dlugosz M. <?php echo $title; ?></title>
<meta charset="utf-8"/>
<meta name="description" content="Este é o meu blog, o blog do Tatsunow, é sobre Thiago Dlugosz Moraes (Programador Nato)"/>
<?php 
if(isset($_GET['module'], $_GET['id']) && $_GET['module'] == "post" && !empty($_GET['id'])){
	
	$id = intval($_GET['id']);
	$posts = new Posts();
	$post = $posts->post($id);
	$tags = $post->Tags;
	echo "<meta name='keywords' content='$tags'/>";
	
}else {
	echo "<meta name='keywords' content='blog do tatsunow,tatsunow,thiago dlugosz, Thiago, TatsunowBlog,ThiagoMoraes,Eraldo Moraes,Tats'/>";
}
?>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script src="js/jquery.js"></script>
<script src="js/script.js"></script>
</head>
<body >
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=575563995884819";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<header>
<div class="links">
<ul>
<li><a href='admin/'>Login</a></li>
<li><a href='#'>Registrar</a></li>
</ul>
</div>
<div class="foto">
<img src="https://scontent-lga.xx.fbcdn.net/hphotos-xap1/v/l/t1.0-9/11050321_1599542876929585_7590710784267401142_n.jpg?oh=fff92b6966db83e1ea8551f0ebbb20b4&oe=55AD72E0"/>
</div>
<span class="nome">Thiago Dlugosz M.</span>
<div class="menu">
<ul>
<?php

 if(isset($_GET['module'])){
     
     $module = $_GET['module'];
	 
     if($module == "about"){
         
         ?>
         <li><a href='/me'>Inicio</a></li>
         <li><a href='/me/?module=about' class='current'>Sobre</a></li>
         <li class="drop"><a href='#'>Postagens</a>
         <ul>
         <li><a href='index.php?module=post&tag=PHP'>Php</a></li>
         <li><a href='index.php?module=post&tag=CSS'>Css</a></li>
         <li><a href="index.php?module=post&tag=JAVA">Java</a></li>
         <li><a href="index.php?module=post&tag=JS">JavaScript</a></li>
         </ul>
         </li>
         <?php
         
     } 
     if($module == "post"){
         
        ?>
        
        <li><a href='/me'>Inicio</a></li>
         <li><a href='/me/?module=about'>Sobre</a></li>
         <li class="drop"><a href='#' class='current'>Postagens</a>
         <ul>
         <li><a href='index.php?module=post&tag=PHP'>Php</a></li>
         <li><a href='index.php?module=post&tag=CSS'>Css</a></li>
         <li><a href="index.php?module=post&tag=JAVA">Java</a></li>
         <li><a href="index.php?module=post&tag=JS">JavaScript</a></li>
         </ul>
         </li>
        
        <?php
         
         
     }
	 if($module == "search"){
         
        ?>
        
        <li><a href='/me'>Inicio</a></li>
         <li><a href='/me/?module=about'>Sobre</a></li>
         <li class="drop"><a href='#' class='current'>Postagens</a>
         <ul>
         <li><a href='index.php?module=post&tag=PHP'>Php</a></li>
         <li><a href='index.php?module=post&tag=CSS'>Css</a></li>
         <li><a href="index.php?module=post&tag=JAVA">Java</a></li>
         <li><a href="index.php?module=post&tag=JS">JavaScript</a></li>
         </ul>
         </li>
        
        <?php
         
         
     }
     
     
 } else {
     ?>
     <li><a href='/me' class='current'>Inicio</a></li>
     <li><a href='/me/?module=about'>Sobre</a></li>
      <li class="drop"><a href='#'>Postagens</a>
         <ul>
         <li><a href='index.php?module=post&tag=PHP'>Php</a></li>
         <li><a href='index.php?module=post&tag=CSS'>Css</a></li>
         <li><a href="index.php?module=post&tag=JAVA">Java</a></li>
         <li><a href="index.php?module=post&tag=JS">JavaScript</a></li>
         </ul>
         </li>
    <?php
     
 }

?>
</ul>
</div>
</header>
<div class="conteudo">
<?php
if(isset($_GET['module'])){
    
    $module = $_GET['module'];
    
	 if($module == "search" && isset($_GET['query']) && !empty($_GET['query'])){
		 
		 $query = $_GET['query'];
		 $posts = new Posts();
		 $result = $posts->getResults($query, "me_posts", "Nome");
		 ?>
	       <form method="GET" action="">
	       <input type="hidden" name="module" value="search"/>
	       <input type="text" style="padding: 12px; width: 255px; background: #fff; border: none; outline-color: red;" name="query" required/>	
	       <input type="submit" class="btn btn-green" value="Pesquisar"/>
	       </form>
	      <br />
	     <?php
		 echo $result;
		 
		 
	 }
    if($module == "post" && isset($_GET['id'])){
        
        $id = $_GET['id'];
        if(!empty($id)){
            $id = intval($id);
            
            $posts->getPost($id);
			?>
	       <br /><br />
	<h3>Curte, Comenta & Compartilhe :)</h3>
	<div class="fb-like" data-href="http://www.contememais.com/me/?module=post&id=<?php echo $id; ?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
	<div class="fb-comments" data-width="100%" data-href="http://www.contememais.com/me/?module=post&id=<?php echo $id; ?>" data-numposts="30" data-colorscheme="light"></div>
	        <?php
            
        }
        
    }
    if($module == "post" && isset($_GET['tag'])){
        
        $tag = $_GET['tag'];
        
        if(!empty($tag)){
            
          echo "<h3>Postagens da Categoria: $tag</h3>";
          $posts->getPostsByTag($tag);    
            
        }
        
        
    }
    if($module == "about"){
        
        $cfg = new Config();
		echo $cfg->getPart("sobre");
        
    }
    
} else {
?>
<h3>Postagens</h3>
<form method="GET" action="">
<input type="hidden" name="module" value="search"/>
<input type="text" style="padding: 12px; width: 255px; background: #fff; border: none; outline-color: red;" name="query" required/>	
<input type="submit" class="btn btn-green" value="Pesquisar"/>
</form>
<br /><br />
<?php 
$posts->getPosts();
$cfg = new Config();
echo $cfg->getPart("inicio");
}

?>
</div>

</body>
</html>