<?php

require_once 'app/init.php';

if (isset($_SESSION['email'])) {
    $user = new Usuario();
    $user->deslogar();
} else {
    header("Location: /");
}