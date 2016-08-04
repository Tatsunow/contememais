<?php
require_once 'app/init.php';
$error = "";
$display = "none";
if(isset($_SESSION['error'])){
if(isset($_GET['sign'])){
header("Location: signin.php");
}
$error = $_SESSION['error'];
unset($_SESSION['error']);
$display = "block";
}
if (isset($_POST['email'], $_POST['senha'])) {
    if ($_POST['email'] != NULL && $_POST['senha'] != NULL) {
        $user = new Usuario();
        $user->logar();
    } else {
        $_SESSION['error'] = 'Preencha todos os campos';
    }
}
$logado = new Usuario();
if ($logado->checarSessao($_SESSION['email'])) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Conte-me Mais! - Login</title>
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
            <div class="box box-simple">
              <center>
                <h2>Login no Conte-me mais.</h2></center><br />
                <form method="POST" action="login.php">
                    Email:<br />
                    <input class="textfield" type="text" name="email" placeholder="Email"/><br /><br />
                    Senha:<br />
                    <input class="textfield" type="password" name="senha" placeholder="Senha"/><br /><br />
                    <button class="btn btn-info" type="submit">Login</button>
                    <br />
                    <div class="alert alert-danger" style="display: <?php echo $display; ?>;"><?php echo $error;?></div><br />
                    <br />
                    Ou se preferir, logue-se aqui: <a class="blink" href="signin.php">www.contememais.com/signin.php</a>
                </form>
            </div>
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
        </div>
    </body>
</html>