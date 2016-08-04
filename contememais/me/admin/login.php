<?php
require_once "../fun/init.php"; 

$user = new User();

  if($user->isLogged()){
	  
      header("Location: /me/admin");	  
	  
  }


  if(isset($_POST['user'], $_POST['pass'])){
	  
	  $usu = $_POST['user'];
	  $pass = $_POST['pass'];
	  $user->logar($usu, $pass);
	  
  }

?>
<html>
  <head>
   <title>Login no Painel</title>
   <meta charset="utf-8"/>
   <link rel="stylesheet" type="text/css" href="css/login.css"/>
  </head>
   <body>
	   <div class="geral">
		<div class="head"><h1>Login No Painel</h1></div>
		<div class="body">
	   <form method="POST" action="">
		   <input type="text" class="texto" name="user" placeholder="Usuário" required/><br /><br />
		   <input type="password" class="texto" name="pass" placeholder="Senha" required/><br /><br />
		   <input type="submit" class="botao" value="Login" /><br /><br />
	   </form>
		  </div>
	   </div>
	</body>
</html>