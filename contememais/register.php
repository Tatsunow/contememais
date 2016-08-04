<?php
require_once 'app/init.php';
if (isset($_POST['firstname'], $_POST['lastname'], $_POST['dia'], $_POST['mes'], $_POST['ano'], $_POST['email'], $_POST['senha'])) {
    if ($_POST['firstname'] != NULL && $_POST['lastname'] != NULL && $_POST['dia'] != NULL && $_POST['mes'] != NULL && $_POST['ano'] != NULL && $_POST['email'] != NULL && $_POST['senha'] != NULL) {
        $user = new Usuario();
        $user->criarUsuario();
    } else {
        $_SESSION['msg'] = '<div class="alert alert-danger">Preencha todos os campos.</div>';
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
        <title>Conte-me Mais! - Registrar</title>
        <base href="<?php echo BASE_URL; ?>" target="_parent" />
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
    </head>
    <body>
        <div class="menu">
            <ul>
                <?php Menu::mostrar(); ?>
            </ul>
        </div>
        <div id="main">
            <div class="box box-simple">
                <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>
                <form method="POST" action="register.php">
                    Nome:<br />
                    <input class="textfield" type="text" name="firstname" placeholder="Nome"/><br /><br />
                    Sobrenome:<br />
                    <input class="textfield" type="text" name="lastname" placeholder="Sobrenome"/><br /><br />
                    Data de nascimento:<br />
                    <select name="dia">
                        <option selected>Dia</option>
                        <?php
                        for ($i = 1; $i <= 31; $i++):
                            if ($i < 10) {
                                $i = '0' . $i;
                            }
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        endfor;
                        ?>
                    </select>
                    <select name="mes">
                        <option selected>Mês</option>
                        <?php
                        for ($i = 1; $i <= 12; $i++):
                            if ($i < 10) {
                                $i = '0' . $i;
                            }
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        endfor;
                        ?>
                    </select>
                    <select name="ano">
                        <option selected>Ano</option>
                        <?php
                        for ($i = 1900; $i <= date("Y"); $i++):
                            echo '<option value="' . $i . '">' . $i . '</option>';
                        endfor;
                        ?>
                    </select>
                    <br /><br />
                    Email:<br />
                    <input class="textfield" type="email" name="email" placeholder="Email"/><br /><br />
                    Senha:<br />
                    <input class="textfield" type="password" name="senha" placeholder="Senha"/><br /><br />

                    <input class="btn" type="submit"  value="Registrar"/>
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