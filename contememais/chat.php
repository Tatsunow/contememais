<?php require_once 'app/init.php'; 
$user = new Usuario();
$user->protege();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Conte-me mais! - Chat</title>
        <base href="<?php echo BASE_URL; ?>" target="_parent" />
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
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
            <div class="box box-simple" style="width: 90%">
               Olá, eu sou Thiago, eu fiz essa página para vocês poderem conversar entre si.<br />
               Enquanto eu não faço um sistema de bate papo eu vou deixar esse mesmo ok.<br />
               <br />
               <embed wmode="transparent" src="http://www.xatech.com/web_gear/chat/chat.swf" quality="high" width="850" height="550" name="chat" FlashVars="id=213449091" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://xat.com/update_flash.php" />


            </div>
        </div>
    </body>
</html>