<?php

session_start();

 spl_autoload_register(function($class){
     
     if(file_exists("fun/classes/$class.php")){
         
         include_once "fun/classes/$class.php";
         
         
     } else {
         
         die("A Classe $class Não existe.");
         
     }
     
     
     
 });

$site = array(
"host" => "mysql.hostinger.com.br",
"user" => "u300268666_site",
"pass" => "sunow180569",
"db" => "u300268666_site"
);

try {

    $pdo = new PDO("mysql:host={$site['host']};dbname={$site['db']}", $site['user'], $site['pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

    $pdo->exec("SET NAMES utf8");

} catch (PDOException $e) {

    exit($e->getMessage());

}

?>