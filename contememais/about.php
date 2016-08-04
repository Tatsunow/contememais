<?php 
require_once 'app/init.php'; 
if(isset($_POST['email'], $_POST['subject'], $_POST['msg'])){
$from = $_POST['email'];
$assunto = $_POST['subject'];
$to = "tiago_mastermix@hotmail.com";
$msg = $_POST['msg'];
mail($to, $assunto, "", "Email enviado por: $from responda mandando um email para $from.\n\n Mensagem: \n$msg \n\nAtt Tatsunow.");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Conte-me mais! - Sobre 
        <?php 
        if(isset($_GET['about'])){
        $abouting = $_GET['about'];
        echo ucfirst($abouting);
        }
        ?></title>
        <base href="<?php echo BASE_URL; ?>" target="_parent" />
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
                <meta name="description" content="Conte-me mais é uma Rede social baseada no facebook."/>
                <meta name="keywords" content="contememais,ctmm,conte-me mais,contememais.com, conte me mais,Tatsunow,Thiago Dlugosz,conteme mais com,contememais.com, conteme mais, conte-me mais!"/>
    </head>
    <body>
        <div class="menu">
            <div class="tofoot">
                Conte-me Mais!
            </div>
            <ul>
                <?php Menu::mostrar(); ?>
            </ul>
        </div>
        <div id="main">
            <div class="box box-simple" style="width: 90%">
            <?php 
               if(!isset($_GET['about'])){
                echo '
                Eu, Tatsunow desenvolvi o Conte-me mais! com uma ajuda de João Paulo.<br />
                Nomes:<br />
                Thiago Dlugosz Moraes e João Paulo da Silva<br />
                Email para contato:
                tiago_mastermix@hotmail.com<br />
                Página no facebook:
                <a href="http://facebook.com/contememais">http://facebook.com/contememais</a><br /><br />
                <img class="thumbnail" src="https://fbcdn-sphotos-h-a.akamaihd.net/hphotos-ak-xpf1/v/t1.0-9/10612865_1548203732063500_7326062381054280382_n.jpg?oh=7258f861256dbaa2f50c7d44ca82262e&oe=5578ED25&__gda__=1433989402_29cb77dcd6704ed42dcb59d6e1eab1c4"/><br />
                <br />
                Outros Links que Podem te Ajudar:<br /><br />
                <li><a href="about.php?about=posting" class="blink">Postando</a></li>
                ';   
               } else {
                   $abouting = $_GET['about'];
                   if($abouting == "posting"){
                       ?>
                       <a class='blink' href='about.php'>Sobre</a> / <a class='blink' href='about.php?about=posting'>Postando</a><br /><br />
                       <h3>Colocando Smilies:</h3><br />
                       <img src="media/images/img.JPG"/><br />
                       Clique na carinha feliz, e depois clique na carinha que você quer.<br /><br /><br />
                       <h3>Colocando Vídeo:</h3><br />
                       <img src="media/images/video.PNG"/><br /><br />
                       E Depois Clique em Publicar, pronto o vídeo foi compartilhado com os Usuários.<br /><br />
                       Post Escrito Por <a href="perfil.php?uuid=2f2e8238-18ca-4823-9b2c-91b8a574527e" class="blink">Tatsunow</a>.
                       
                       
                       <?php
                   }
               }
            ?>
            <br /><br />
            Olá Tudo Bom? aqui é Tatsunow. Mande-nos um email!<br />
               <form method="POST" action="" class="mailForm">
               <input type="text" placeholder="Seu E-mail" name="email"/><br /><br />
               <input type="text" placeholder="Assunto" name="subject"/><br /><br />
               <textarea name="msg" placeholder="Sua mensagem..."></textarea><br /><br />
               <input type="submit" value="Enviar email"/>
               </form>
            </div>
        </div>
    </body>
</html>