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
 
 public function conecta()
 {
     global $pdo;
     $this->db = $pdo;
 }
 
}
?>