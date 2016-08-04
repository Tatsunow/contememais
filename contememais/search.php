<?php
require_once 'app/init.php';
$user = new Usuario();
$user->protege();
$query = "";
if(!isset($_GET['query'])){
header("Location: /");
} else {
$query = $_GET['query'];
$query = str_replace("+", " ", $query);
}
$results = $user->search($query);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Conte-me mais! - Pesquisa Por <?php echo $query; ?></title>
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
              Resultados da Pesquisa Por: <b><?php echo $query; ?></b>
              <?php
              echo $results;
              ?>
            </div>
        </div>
    </body>
</html>