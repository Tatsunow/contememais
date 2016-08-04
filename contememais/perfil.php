<?php
require_once 'app/init.php';
error_reporting(0);
$user = new Usuario();
$user->protege();
session_start();
$email = $_SESSION['email'];
$arehim = "false";
$uuid = $user->retorno($email)->uuid;
if (isset($_GET['nick'])) {
    $email = $user->emailbynick($_GET['nick']);
    $uuid = $user->retorno($email)->uuid;
	if($user->getuuid() == $uuid){
        $arehim = true;
    } else {
        $arehim = false;
    }
}
if (isset($_GET['uuid'])) {
    $email = $user->emailbyuuid($_GET['uuid']);
    $uuid = $_GET['uuid'];
    if($user->getuuid() == $uuid){
        $arehim = true;
    } else {
        $arehim = false;
    }
}
$age = $user->getAge($uuid);
$nome = $user->retorno($email)->nome . " " . $user->retorno($email)->sobrenome;
if(isset($_POST['new']) && ($uuid == $user->getuuid() || $user->isAdmin())){
$newvalue = $_POST['new'];
$user->changeStatus($user->emailbyuuid($uuid), $newvalue);
}
$status = $user->retorno($email)->status;
if (empty($status) || $status == "" || $status == " ") {
    $status = "Este usuário não definiu seu status.";
}

$foto = "";
if(file_exists("media/images/perfilImages/$uuid.jpg")){
$foto = "media/images/perfilImages/$uuid.jpg";
} else {
if(!empty($user->getImagem($uuid))){
$foto = $user->getImagem($uuid);
} else {
$foto = "media/images/perfilImages/default.png";
}
}
// envia msg privada
if(isset($_POST['msg'])){
$msg = $_POST['msg'];
if(!empty($msg)){
$user->inbox($msg, $uuid);
}
}
// envia foto
$arquivo = isset($_FILES["foto"]) ? $_FILES["foto"] : FALSE;
$config = array();
$config["tamanho"] = 100000; 
$config["largura"] = 1280;
$config["altura"] = 720;
$config["diretorio"] = "media/images/perfilImages/";
if($arquivo)
{
    $erro = array();
    

    if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
    {
        $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $erro[] = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
        }
        
        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);
        
        // Verifica largura
        if($tamanhos[0] > $config["largura"])
        {
            $erro[] = "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if($tamanhos[1] > $config["altura"])
        {
            $erro[] = "Altura da imagem não deve ultrapassar " . $config["altura"] . " pixels";
        }
    }

    if(!sizeof($erro))
    {
        // Pega extensão do arquivo, o indice 1 do array conterá a extensão
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
        
        // Gera nome único para a imagem
        $imagem_nome = "$uuid.jpg";

        // Caminho de onde a imagem ficará
        $imagem_dir = $config["diretorio"] . $imagem_nome;

        // Faz o upload da imagem
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Conte-me mais! - Perfil de <?php echo $nome; ?></title>
        <base href="<?php echo BASE_URL; ?>" target="_parent" />
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
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
        <input type="text" placeholder="Pesquise Por pessoas" class="textfield" name="query" >
        <input type='submit' class='btn' value="Pesquisar"/> 
        </form>
        </li>
        </ul>
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
                    </ul>
                </div>
            </div>
            <div class="box box-simple">
               <center><img class='thumbnail' src='<?php echo $foto; ?>' id='perfil_foto'/>
               <br />
               <a class='perfil_nome' href="<?php echo $user->getProfileLink($user->emailbyuuid($uuid));?>"><?php echo $nome . " ($age Anos)"; ?></a><br /><br />
               <?php
               if($arehim || $user->isAdmin()){
                  ?>
                  <form method="POST" action="">
                 <textarea name="new" style='height: 70px' class="textfield"><?php echo $status;?></textarea><br />
                 <input type="submit" class="btn" value="Salvar"/>
                 </form>
                 <br /><br />
                 <form action="" method="post" enctype="multipart/form-data">
                 <input class='textfield' type="file" name="foto">
                 <input class='btn' type="submit" value="Enviar foto"> 
                 </form>

                  <?php
               } else {
                   ?>
                   <div class="textfield" style="height: 70px">
                   <?php echo $status; ?>
                   </div>
                   <?php
               }
               
               ?>
                <?php
                if(!$arehim){
                ?>
                <br /><br />
                <form method="POST" action="">
                Enviar mensagem privada para: <?php echo $nome;?><br />
                <textarea name="msg" class='textfield' style='font-family: Trebuchet MS;'></textarea><br />
                <input type="submit" value="Enviar" class="btn"/>
                </form><br /><br />
                 <div class='box box-simple' style="width: 86%">
                <?php
                }
                if($arehim || $user->isAdmin()){
                $count = $user->messagescount($uuid);
                if($count != 0){
                    echo "Quantidade de Inbox: (<b>" . $count . "</b>)<br /><br />";
                    ?>
                    Mensagens Privadas: <br /><br />
                    <?php
                    $msgs = $user->messages($uuid);
                    echo $msgs;
                }
                }
                ?>
                </div>
               </center>
            </div>
        </div>
    </body>
</html>