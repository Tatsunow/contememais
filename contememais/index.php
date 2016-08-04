<?php 
  
  require_once 'app/init.php'; 
  
  $user = new Usuario();
  
  $user->protege();
  
  $post = new Post();

  // cria o post
  if(isset($_POST['message'])) {
	  
	$msg = $_POST['message'];
	
	if(!empty($msg)) {
		
		$id = $post->criaPost($msg);
		header("Location: #" . $id);
    } else {
		$_SESSION['error'] = "Você deve escrever algo em seu post.";
	}
  }
  
  // deleta o post
  if(isset($_GET['delete'])) {
	  
	  $id = $_GET['delete'];
	  
	  if(!empty($id)){
		  $post->deletaPost($id);
		  header("Location: index.php");
	  } else {
		  $_SESSION['error'] = "O ID Não pode ser vazio!";
	  }
  }
  
  //comenta no post
  if(isset($_POST['ct'])){
	  
	  $id = $_POST['id'];
	  $uuid = $_POST['uuid'];
	  $msg = $_POST['ct'];
	  if(!empty($msg)){
	  
	  $post->comenta($id, $uuid, $msg);
      header("Location: index.php#$id");		
	  } else {
		  $_SESSION['error'] = "Você tem que colocar algo em seu comentário.";
		  return;
	  }
	  
  }
  
  //tira o comentario do post
  if(isset($_GET['deletecmt']) && !empty($_GET['deletecmt'])){
	  $valores = explode("," ,$_GET['deletecmt']);
	  $cuuid = $valores[0];
	  $id = $valores[1];
	  if($post->getcmtuuid($cuuid) == $user->getuuid() || $user->isAdmin()){
		  $post->closecomment($id, $cuuid);
		  header("Location: index.php#" . $id);
	  }
  }
 // fixa o post
  if(isset($_GET['fixa']) && !empty($_GET['fixa']) && $user->isAdmin()){
    $id = $_GET['fixa'];
     $post->fixa($id);
   }
// desfixa o post
if(isset($_GET['desfixa']) && !empty($_GET['desfixa']) && $user->isAdmin()){
     $post->desfixa();
   }
// curte o post
if(isset($_GET['curte']) && !empty($_GET['curte']) && $user->existPost(intval($_GET['curte']))){
$post->like(intval($_GET['curte']), $user->getuuid());
header("Location: index.php#" . $_GET['curte']);
}
// torna adm
if(isset($_GET['setadmin'])){
$uuid = $_GET['setadmin'];
if(!empty($uuid)){
$user->setaAdmin($uuid);
}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Conte-me mais! -
            <?php
            if(isset($_GET['module'])){

                $mod = $_GET['module'];
                if($mod == "jogos") echo "Jogos";
                if($mod == "blog") echo "Blog";
				if($mod == "batepapo") echo "Bate-papo";

            } else {

                echo "Social Network";

            }
            ?>

        </title>
        <base href="<?php echo BASE_URL; ?>" target="_parent" />
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
		<script src="js/profile.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="media/tipped/js/tipped/tipped.js"></script>
		<link rel="stylesheet" type="text/css" href="media/tipped/css/tipped/tipped.css"/>
                <meta name="description" content="Conte-me mais é uma Rede social baseada no facebook."/>
                <meta name="keywords" content="contememais,ctmm,conte-me mais,contememais.com, conte me mais,Tatsunow,Thiago Dlugosz,conteme mais com,contememais.com, conteme mais, conte-me mais!"/>
    </head>
    <body>
        <div class="menu">
            <ul>
                <?php Menu::mostrar(); ?>
            </ul>
        </div>
        <div class="topMenu">
        <ul>
        <li>
        <form method="GET" action="search.php">
        <input type="text" placeholder="Pesquise Por Pessoas" class="textfield" name="query" >
        <input type='submit' class='btn' value="Pesquisar"/> 
        Quantidade de Inbox: <?php echo $user->messagescount($user->retorno($_SESSION['email'])->uuid); ?>
        </form>
        </li>
        </ul>
        </div>
        <div id="showarea">
        <br /><br /><br />
        <div class="right"><button onclick="closeShowing();">✕</button></div>
        <div class="writeable">
        
        </div>
        </div>
        <div id="main">
            <div class="ads">

                <?php
                $ads = new ads();
                echo $ads->getAds();
                ?>
                <div class="footer">
                    <ul>
                        <li><a href="about.php">Sobre</a></li>
                        <li><a href="terms.php">Termos</a></li>
                        <li><a href="tacos.php">Tacos</a></li>
                    </ul>
                </div>
            </div>
                <div class="box box-simple">
				<?php
                if(isset($_GET['module'])){
                    $module = $_GET['module'];
					
					if($module == "batepapo"){
						?>
					
					  <script id="cid0020000089949225040" data-cfasync="false" async src="//st.chatango.com/js/gz/emb.js" style="width: 600px;height: 512px;">{"handle":"conte-memais","arch":"js","styles":{"b":100,"c":"000000","d":"000000","l":"FFFFFF","m":"FFFFFF","p":"10","r":100,"ab":false,"surl":0,"fwtickm":1}}</script>
					
					   <?php
						return;
						
					}
                    if($module == "membros"){

                        echo "<h3>Esses são os membros registrados no site: <br /></h3>" . $user->search("");
                        return;

                    }
                    if($module == "jogos"){

                        ?>
                        <script>

                            function joga(jogo){

                                var jogodiv = document.getElementById("jogo");
                                if(jogo == "pacman"){

                                    jogodiv.innerHTML = "<embed src='http://jogueaqui.ig.com.br/jogos/pacman.swf' width='615' height='512'>";
                                } else if(jogo == "mario"){

                                    jogodiv.innerHTML = "<embed src='http://mrjogos.uol.com.br/_arquivos/jogosonline/games/super-mario-bros.swf' width='615' height='512'>";
                                } else if(jogo == "pou"){

                                    jogodiv.innerHTML = '<iframe id="frame" width="615" height="512" src="http://static1.scirra.net/arcade/games/8180/play" frameborder="0" scrolling="no"></iframe>';
                                } else if(jogo == "crash"){

                                    jogodiv.innerHTML = "<embed src='http://mrjogos.uol.com.br/_arquivos/jogosonline/games/2153.swf' width='615' height='512'>";
                                } else if(jogo == "fireandwater"){

                                    jogodiv.innerHTML = "<embed src='http://www8.agame.com/mirror/flash/f/Fireboy_and_watergirls4_crystal_temple/FireBoyAndWaterGirl.swf' width='615' height='512'>";
                                }
                            }
                        </script>
                        <h2>
				   Pac-man<br /></h2>
				   <button onclick="joga('pacman');" class="btn btn-danger">Jogar</button>
				 <h2>
				   Mario bros<br /></h2>
				   <button onclick="joga('mario');" class="btn btn-danger">Jogar</button>
			    <h2>
				   Pou<br /></h2>
				   <button onclick="joga('pou');" class="btn btn-danger">Jogar</button>
				<h2>
				   Crash Bandicoot<br /></h2>
				   <button onclick="joga('crash');" class="btn btn-danger">Jogar</button>
				<h2>

					Fogo e agua<br />
					<button onclick="joga('fireandwater');" class="btn btn-danger">
					Jogar
					</button>
				</h2>
				   <div id="jogo">

				   </div>


                         <?php
                        return;

                    }

                    if($module == "blog"){

                        ?>
                        <?php
                         if(isset($_GET['viewpost'])){

                             if(isset($_GET['action'])){

                                 $act = $_GET['action'];

                                 if($act == "deletar" && $user->isAdmin()){

                                     $id = intval($_GET['viewpost']);
                                     $post->deletaBlogPost($id);
                                     header("Location: index.php?module=blog");

                                 }

                             return;
                             }

                             $id = intval($_GET['viewpost']);
                             $post->getBlogPost($id);

                             return;
                         }
                         if(isset($_GET['action'])){

                             $act = $_GET['action'];



                             if($act == "postar"){

                                 if(isset($_POST['nome'], $_POST['conteudo']) && $user->isAdmin()){

                                     $autor = $user->getuuid();
                                     $nome = $_POST['nome'];
                                     $conteudo = $_POST['conteudo'];

                                      $post->blogPost($nome, $conteudo, $autor);


                                 }


                             }

                         }

                         if($user->isAdmin()){
                             ?>
                             <form method="post" action="index.php?module=blog&action=postar">
                                 <input class="textfield" style="width: 500px;" type="text" placeholder="Nome do post" name="nome" required/><br /><br />
                                 <textarea style="width: 500px; height: 210px; font-family: 'Trebuchet MS' resize: none;" name="conteudo" class="textfield" placeholder="Postagem" required></textarea><br /><br />
                                 <input type="submit" class="btn" value="Postar"/>
                             </form>
                    <br /><br />
                             <?php

                         }

                             ?>

                           Postagens a baixo: <br />
                        <?php
                      $post->getBlogPosts();
                        return;

                    }


                }
				if(isset($_SESSION['error'])){
				echo '<center><span class="alert alert-danger">' . $_SESSION['error'] . '</span></center><br /><br />';
				unset($_SESSION['error']);
				}
				?>
				</span>
				<b>Envie uma mensagem aos utilizadores, para saber mais sobre isso <a href="about.php?about=posting">clique aqui</a></b><br />
				<br />
				<form method="POST" action="">
                <textarea name="message" id='msg' class="textfield" placeholder="Escreva aqui uma mensagem" style="width: 97%; height: 55px; font-family: 'Trebuchet MS'; resize: none;"></textarea><br />
				<div class="alignright"><button class="btn">Publicar</button></div>
				</form>
				<img id='emoticon' style="width: 25px; cursor: pointer;" title='Carinhas' style='cursor: pointer;' src="media/images/emoticons/sorriso.PNG"></img><br />
				<div class="box box-simple" style="width: 30%; display: none;" id="liste">
				<h4>Escolha seu Emoticon</h4>
				</div>
				<script src="js/carinhas.js"></script>
                </div>
				<?php
				$post->getPosts();
				?>
				<script type="text/javascript">
  $(document).ready(function() {
    Tipped.create('.simple-tooltip');
  });
</script>
        </div>
    </body>
</html>
