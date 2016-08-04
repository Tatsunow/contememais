<?php

class adm{

 

 private $db;   

 

 public function __construct(){

     $this->conecta();

 }   

 

 public function pegaAutores()

 {

     $mysql = $this->db->prepare("SELECT * FROM `master_autores`");

     $mysql->execute();

     while($row=$mysql->fetch()){

         $autor = $row->nome;

         echo "<option>$autor</option>";

     }

     

 }

 

 public function loga($autor, $senha){

    

    $sql = $this->db->prepare("SELECT 1 FROM `master_autores` WHERE `nome`=? AND `senha`=?");

    

    $senha = md5($senha);

    

    $sql->bindParam(1, $autor);

    $sql->bindParam(2, $senha);

    

    $sql->execute();

    

    if($sql->rowCount() == 0){

        $_SESSION['erro'] = "Autor ou senha incorreto.";

        return;

    } else {

        $this->setaSessao($autor);

        header("Location: /mastermix/admin/index.php");

    }

 }

 
 
 public function desloga(){

   if(isset($_SESSION['mastermix'], $_SESSION['nome'])){

    unset($_SESSION['nome']);

    unset($_SESSION['mastermix']);

    header("Location: /mastermix/admin/login.php");

   } else {
    header("Location: /mastermix/admin/login.php");
   }
 }

 public function protect(){

 

   if(!$this->isLogado()){

       header("Location: /mastermix/admin/login.php");

       return;

   } else {

       return;

   }

     

 }

 

 

 public function setaSessao($autor){

     

     $_SESSION['nome'] = $autor;

     $cod = md5("Mastermix Secure Website");

     $_SESSION['mastermix'] = $autor . "xYz==$cod" . "2015";

     

 }

 

 public function isLogado(){

     

     if(!isset($_SESSION['nome'], $_SESSION['mastermix']))return false;

     $nome = $_SESSION['nome'];

     $year = "2015";

     $sessao = $_SESSION['mastermix'];

     $cod = md5("Mastermix Secure Website");

     return $sessao == $nome . "xYz==$cod" . $year;

     

 }

 

 

 public function conecta()

 {

     global $pdo;

     $this->db = $pdo;

 }

 

}

?>