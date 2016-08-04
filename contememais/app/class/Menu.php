	<?php

class Menu {

    public static function mostrar() {
        if (isset($_SESSION['email']) && $_SESSION['email'] != NULL) {
            $user = new Usuario();
            if ($user->checarSessao($_SESSION['email'])) {
                $nome = $user->retorno($_SESSION['email'])->nome . " " . $user->retorno($_SESSION['email'])->sobrenome;
                $foto = "";
                $uuid = $user->getuuid();
                if(file_exists("media/images/perfilImages/$uuid.jpg")){
                $foto = "media/images/perfilImages/$uuid.jpg";
                } else {
                if(!empty($user->getImagem($uuid))){
                $foto = $user->getImagem($uuid);
                } else {
                $foto = "media/images/perfilImages/default.png";
                }
                }
                echo "<li class='img'><a href='perfil.php'><img style='width: 83%; height: 80%;' class='thumbnail' src='$foto'/><br />$nome</a></li>";
                echo '<li><a href="/" title="Inicio">Conteme-mais</a></li>';
                echo "<li><a href='perfil.php' title='$nome'>$nome</a></li>";
                echo "<li><a href='chat.php'>Chat</a></li>";
                echo "<li><a href='cfg.php'>Configurações</a></li>";
				echo "<li><a href='index.php?module=jogos'>Jogos</a></li>";
                echo '<li><a href="logout.php" title="Sair de sua conta">Sair</a></li>';
                echo "<li><a href='index.php?module=blog'>Blog</a></li>";
                if($user->isAdmin()){	
                 echo "<li><a href='#'>Painel Administrador</a></li>";
                 echo "<li><a href='index.php?module=membros'>Ver Membros</a></li>";
                }
            }
        } else {
            echo '<li><a href="login.php" title="Iniciar uma sessão">Logar</a></li>';
            echo '<li><a href="register.php" title="Registrar-se no site">Registrar</a></li>';
        }
       echo "<script src='//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script>";
       echo "<script src='../js/util.js'></script>";
    }

}