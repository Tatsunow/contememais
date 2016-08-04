<?php
require_once 'app/init.php';
$user = new Usuario();
$user->protege();
$nomes = explode(" ", $user->getName());
$paranick = $user->getNick();
$yournick = "<a href='perfil.php?perfil=$paranick'>www.contememais.com/perfil.php?nick=$paranick</a>";
if(isset($_POST['nome'], $_POST['sobrenome'], $_POST['nick'], $_POST['pw'])){
$nometo = $_POST['nome'];
$sobrenometo = $_POST['sobrenome'];
$nick = $_POST['nick'];
$pw = $_POST['pw'];
if(!empty($nometo)){
$user->mudaNomePara($nometo);
$nomes = explode(" ", $user->getName());
}
if(!empty($sobrenometo)){
$user->mudaSobrenomePara($sobrenometo);
$nomes = explode(" ", $user->getName());
}
if($nick == "semnick"){
$user->mudaNickPara("");
$nick = "";
$paranick = "";
$yournick = "<a href='perfil.php'>Você não tem um nick</a>";
}
if(!empty($nick)){
if($user->nickexist($nick) == true && !$user->isAdmin()){
$yournick = "Erro ao salvar o nick";
} else {
$user->mudaNickPara($nick);
$paranick = $nick;
$yournick = "<a href='$nick/'>www.contememais.com/perfil.php?nick=$nick</a>";
}
}
if(!empty($pw)){
$count = count_chars($pw);
if($count >= 6){
$user->mudaSenha($pw);
} 
}
}
$nome = $nomes[0];
$sobrenome = $nomes[1] . " " . $nomes[2]. " " . $nomes[3]. " " . $nomes[4] . " " . $nomes[5] . " " . $nomes[6];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Conte-me mais! - Configurações <?php echo $query; ?></title>
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
        <input type="text" placeholder="Pesquise Por pessoas" class="textfield" value="<?php echo $query; ?>" name="query" >
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
              <form method="POST" action="">
              Primeiro Nome: <br /><br />
              <input type="text" class="textfield" style='width: 35%' name="nome" placeholder="<?php echo $nome; ?>"/><br /><br />
              Segundo Nome: <br /><br />
              <input type="text" class="textfield" style="width: 35%" name="sobrenome" placeholder="<?php echo $sobrenome; ?>"/><br /><br />
              Nick: (Vai ser a forma de acessar seu perfil por exemplo: www.contememais.com/perfil.php?uuid=Tatsunow12)<br /><br />
              Seu Nick Atual: <?php echo $yournick; ?><br /><br />
              <input type="text" class="textfield" id="nick" style="width: 35%" name="nick" placeholder="Seu Nick"/><br /><br />
			  Mudar Senha: <br /><br />
			  <input type="password" style="width: 35%" class="textfield" name="pw" placeholder="Nova Senha"/><br /><br />
              <button type="button" class="btn" onclick="document.getElementById('nick').value= 'semnick';">Retirar Nick</button>
              <input type="submit" class="btn" value="Salvar Alterações"/>
              </form>
            </div>
        </div>
    </body>
</html>