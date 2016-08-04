<?php


session_start();


spl_autoload_register(function($class) {

    if (file_exists('app/class/' . $class . '.php')) {

        include_once 'app/class/' . $class . '.php';

    } else {

        die("A classe " . $class . " não existe!");

    }

});



date_default_timezone_set('America/Sao_Paulo');



$site = [

    'host' => 'mysql.hostinger.com.br',

    'db' => 'u300268666_site',

    'user' => 'u300268666_site',

    'pass' => 'sunow180569',

];



try {

    $pdo = new PDO("mysql:host={$site['host']};dbname={$site['db']}", $site['user'], $site['pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $pdo->exec("SET NAMES utf8");

} catch (PDOException $e) {

    exit($e->getMessage());

}


?>