<?php
require_once "../fun/init.php";
$user = new User();
$user->proteger();

if(isset($_POST['act'], $_POST['nome'], $_POST['user'], $_POST['pass'], $_POST['foto'], $_POST['fonte']) && !empty($_POST['act']) && $_POST['act'] = "changeprofileinfo"){
	
	$nome = $_POST['nome'];
	$usu = $_POST['user'];
	$pass = $_POST['pass'];
	$foto = $_POST['foto'];
	$fonte = $_POST['fonte'];
	$user->change($foto, $nome, $usu, $pass, $fonte);
	
}
if(isset($_GET['action']) && $_GET['action'] == "delete" && isset($_GET['id']) && !empty($_GET['id'])){
	
	$id = intval($_GET['id']);
	$posts = new Posts();
	$posts->deletar($id);
	header("Location: index.php?module=posts");
	
}
if(isset($_POST['title'], $_POST['content'], $_POST['tags'], $_POST['act'], $_POST['id']) && $_POST['act'] == "edit"){
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	$tags = $_POST['tags'];
	$id = $_POST['id'];
	$posts = new Posts();
	$posts->edita($id, $title, $content, $tags);
	header("Location: index.php?module=posts&id=$id");
	return;
}
if(isset($_POST['title'], $_POST['content'], $_POST['tags'])){
	
	$title = $_POST['title'];
	$content = $_POST['content'];
	$tags = $_POST['tags'];
    $posts = new Posts();
	$posts->postar($title, $content, $tags);
	header("Location: index.php?module=posts");
	
}
if(isset($_POST['newvalue'], $_POST['parte'])){
	
	$nv = $_POST['newvalue'];
	$part = $_POST['parte'];
	if(!empty($nv) && !empty($part)){
		
		$cfg = new Config();
		$cfg->setPart($part, $nv);
		
	}
	
}
if(isset($_GET['action'])){
	
	$act = $_GET['action'];
	
	if($act == "logout") {
		
		$user->sair();
		
	}
	
	if($act == "gerahash" && isset($_GET['text'])){
		
		$hash = $_GET['text'];
		$hash = $user->geraHash($hash);
		echo $hash;
		
	}
	
}
$title = $user->getName();
if(isset($_GET['module'])){
	
	$mod = $_GET['module'];
	
	if($mod == "posts" && !isset($_GET['id'])){
	
		 $title = "Postagens";
		
	}
	
	if($mod == "posts" && isset($_GET['id'])) {
		
		$id = intval($_GET['id']);
		$posts = new Posts();
		$nom = $posts->getPostName($id);
		$title = "Visualizando post: $nom";
	}
	
}
?>
<html>
<head>
<title>Painel de Administração - <?php echo $title;?></title>
<meta charset="utf-8"/>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '828551400568316',
      xfbml      : true,
      version    : 'v2.3'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=575563995884819";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<header>
<ul>
<li><a href='index.php'>Inicio</a></li>
<li><a href='index.php?module=posts'>Postagens</a></li>
<li><a href='index.php?module=config'>Configurações</a></li>
<li class="drop"><a href='#'><?php echo $user->getName(); ?> ▼</a>
<ul>
<li><a href='index.php?module=profile'>Perfil</a></li>
<li><a href='index.php?action=logout'>Sair</a></li>
</ul>	
</li>
</ul>
</header>
<div class="geral">
<div class="painel">
<?php
    
   if(isset($_GET['module']) && !empty($_GET['module'])){
	   
	   $module = $_GET['module'];
	   
	   if($module == "profile"){
		   
		   $usu = $user->retorno($_SESSION['usuario']);
		   $fonte = $user->getFonte($_SESSION['usuario']);
		   ?>
	       <h3>Informações do perfil</h3>
	       <br />
	       <form method="POST" action="">
			   
			 <img style="border-radius: 100%; width: 150px; height: 150px; border: 2px solid #fff;" src="<?php echo $usu->foto; ?>" title="Foto do Perfil"/><br /><br />
			 Foto do Perfil: <br />
			 <input type="text" class="textfield" name="foto" value="<?php echo $usu->foto; ?>"/><br /><br />
			 Fonte: <br />
			 <input type="text" class="textfield" name="fonte" value="<?php echo $fonte; ?>"/>
			 <br /><br /> 
			 <input type="hidden" name="act" value="changeprofileinfo"/>
			 Nome: <br />
			 <input type="text" class="textfield" name="nome" value="<?php echo $usu->nome; ?>" placeholder="Nome Completo"/><br /><br />
			 Usuario: <br />
			 <input type="text" class="textfield" name="user" value="<?php echo $usu->user; ?>" placeholder="Usuário"/><br /><br />
			 Senha: <br />
			 <input type="password" class="textfield" name="pass" placeholder="Sua senha"/><br /><br />
			 <input type="submit" class="btn" value="Salvar Mudanças"/>
	       </form>
	       <?php
		   return;
	   }
	   
	   
	   if($module == "config"){
		   
		   $cfg = new Config();
		   
		   ?>
	       <h1>Configurações do Blog</h1>
	       <span class="divisor"></span>
	       <form method="POST" action="">
		
			   <h2>Página inicial</h2>
			   <br />
			  <textarea name="newvalue" id="texto">
			  <?php echo $cfg->getPart('inicio'); ?>
			   </textarea>  
			  <br /><br />
			   <input type="hidden" name="parte" value="inicio"/>
              <button type="submit" class="btn">Salvar Modificações </button>
	      </form>
	        <br /><br /><br />
	     <form method="POST" action="">
		
			   <h2>Página Sobre</h2>
			   <br />
			  <textarea name="newvalue" id="texto">
			  <?php echo $cfg->getPart('sobre'); ?>
			   </textarea>  
			  <br /><br />
			   <input type="hidden" name="parte" value="sobre"/>
              <button type="submit" class="btn">Salvar Modificações </button>
			    
	      </form>
	
	      <?php
		   return;
	   }
	   
	   if($module == "posts" && isset($_GET['action']) && $_GET['action'] == "edit" && isset($_GET['id']) && !empty($_GET['id'])){
		   
		   $id = intval($_GET['id']);
		   $posts = new Posts();
           $post = $posts->post($id);
		   ?>
	     <h2>Editar Postagem</h2>
	        <br />
	      <form method="POST" action="">
		   <input type="hidden" name="act" value="edit"/>
		   <input type="hidden" name="id" value="<?php echo $post->ID; ?>"/>
           <input type="text" class="textfield" name="title" value="<?php echo $post->Nome; ?>" placeholder="Título da Postagem" required/><br /><br />
           <textarea class="textfield" style="height: 340px; font-family: 'Trebuchet MS';" name="content" placeholder="Conteúdo da Postagem" required>
			<?php echo $post->Post; ?>  
		   </textarea><br /><br />
		   <input type="text" class="textfield" value="<?php echo $post->Tags; ?>" placeholder="Tags da Postagem" name="tags"/><br /><br />
		   <input type="submit" class="btn" value="Concluir Edição"/>
		
	              </form>
          <?php
		   
		   return;
		   
	   }
	   
	   
	   if($module == "posts" && isset($_GET['id']) && !empty($_GET['id'])){
		   
		  $id = intval($_GET['id']);
		  $posts = new Posts();
		  $post = $posts->post($id);
		  ?>
	      <div class="head"><?php echo $post->Nome . " - Por: " . $post->Autor; ?></div>
	      <div class="body">
		  <?php echo $post->Post; ?>	  
	      </div>
	      <br />
	      Tags:
	      <br />
	      <input class="textfield" type="text" value="<?php echo $post->Tags; ?>" />
	      <br /><br />
	      <span style="line-height: -10px; font-weight: bold; font-size: 14pt;">Opções</span>
	      <span class="divisor"></span>
	      <br /><br />
	      <a href="index.php?module=posts&action=delete&id=<?php echo $post->ID; ?>"><button style="width: 80px;" class="btn">Deletar</button></a>
	      <a href='index.php?module=posts&action=edit&id=<?php echo $post->ID; ?>'><button style="width: 80px;" class="btn">Editar</button></a>
	      <a target="_blank" href='../?module=post&id=<?php echo $post->ID; ?>'><button style="width: 125px;" class="btn">Visitar Post</button></a>
	      <?php
		   
		   return;
	   }
	   
	   
	   if($module == "posts"){
		   
		   if(isset($_GET['action'])){
			   
			   $act = $_GET['action'];
			   
			   if($act == "newpost"){
				   ?>
	               <h2>Nova Postagem</h2>
	             <br />
	              <form method="POST" action="">
					   <input type="text" class="textfield" name="title" placeholder="Título da Postagem" required/><br /><br />
					  <textarea class="textfield" style="height: 340px; font-family: 'Trebuchet MS';" name="content" placeholder="Conteúdo da Postagem" required></textarea><br /><br />
					  <input type="text" class="textfield" placeholder="Tags da Postagem" name="tags"/><br /><br />
					  <input type="submit" class="btn" value="Postar"/>
		
	              </form>
	               
	              <?php
				   
				   return;
				   
			   }
			   
			   
		   }
		   
		   ?>
	       <div class="head">Postagens</div>
	         <div class="body">
			   
				<?php 
				 
		           $posts = new Posts();
		           $posts->getManageablePosts();
		          
				 ?>
				 
	         </div>
	        <br /><br />
	      <a href='index.php?module=posts&action=newpost'><button class="btn">Nova Postagem</button></a>
	         <br /><br /><br /><br /><br /><br /><br />
	    
	      <?php
		   return;   
		   
	   }
	   
   } else {
	   $posts = new Posts();
	   ?>
	  Olá, esse aqui é o Painel Administrativo do Blog, nele você pode editar O Blog, criar Postagem e editar postagens.<br />
	  Aqui está alguns links que vão te ajudar:<br /><br />
	  <a href="?module=posts">Postagens do Blog (<?php echo $posts->postcount(); ?>)</a><br />
	  <a href='?module=config'>Configurações do Blog</a><br/>
	  <a href='../'>Visitar o Blog</a>
	  <br /><br /><br /><br /><br /><br /><br /><br />
	  <?php
	   
   }
   
?>
</div>	
	
</div>
</body>
</html>