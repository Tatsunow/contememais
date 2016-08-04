<?php
class post {
    
 private $DB;
 
    public function __construct(){
     
      $this->connect();
     
    }
 
    public function getPost($name){
        
        $name = str_replace("-", " ", $name);
        $mysql = $this->DB->prepare("SELECT * FROM `master_posts` WHERE `Nome` LIKE ?");
        $mysql->bindParam(1, $name);
        $mysql->execute();
        
        $array = array();
        while($data_post=$mysql->fetch()){
            $nome = $data_post->Nome;
            $autor = $data_post->Author;
            $postagem = $data_post->Postagem;
            $cats = $data_post->Categorias;
            $array['Nome'] = $nome;
            $array['Autor'] = $autor;
            $array['Postagem'] = $postagem;
            $array['Categorias'] = $cats;
        }
        return $array;
    }
 
    public function getSearch($by){
        
        $mysql = $this->DB->prepare("SELECT * FROM `master_posts` WHERE `Nome` LIKE '%$by%'");
        $mysql->execute();
        if($mysql->rowCount() == 0){
            echo "Nenhum resultado encontrado para $by";
            return;
        }
        while($dad=$mysql->fetch()){
            $nome = $dad->Nome;
            $autor = $dad->Author;
            $cats = $dad->Categorias;
            $link = strtolower($nome);
            $link = str_replace(" ", "-", $link);
            $texto = "<h4><a class='blink' href='/mastermix/?post=$link'>$nome</a></h4>Postado por $autor<br /><br />";
            echo $texto;
        }
    }
    public function getCategorias(){
        
        $mysql = $this->DB->prepare("SELECT * FROM `master_categorias`");
        $mysql->execute();
        $texto;
        while($dad=$mysql->fetch()){
            $cat = $dad->name;
            $texto = $texto . "<a href='/mastermix/?categoria=$cat'>$cat</a>";
        }
        return $texto;
    }
    
    public function getPostsByCat($cat){
        
        $mysql = $this->DB->prepare("SELECT * FROM `master_posts` WHERE `Categorias` LIKE '%$cat%'");
        $mysql->execute();
        if($mysql->rowCount() == 0){
            echo "Nenhum post encontrado na categoria: $cat";
            return;
        }
        while($row=$mysql->fetch()){
            $nome = $row->Nome;
            $autor = $row->Author;
            $link = strtolower($nome);
            $link = str_replace(" ", "-", $link);
            $link = "<a class='blink' href='/mastermix/?post=$link'>$nome.</a>";
            $linkb = str_replace("$nome", "Ver mais..", $link);
            echo "$link Postado por $autor<br />$linkb<br /><br />";
        }
    }
    
    
    public function getAllPosts(){
        
        $mysql = $this->DB->prepare("SELECT * FROM `master_posts` ORDER BY `ID` DESC");
        $mysql->execute();
        
        while($dad=$mysql->fetch()){
            $nome = $dad->Nome;
            $autor = $dad->Author;
            $postag = $this->encurta($dad->Postagem, 45);
            $link = strtolower($nome);
            $link = str_replace(" ", "-", $link);
            echo "<h3>$nome</h3> 
            Postado por <b>$autor</b><br />$postag<br /><h4><a class='blink' href='/mastermix/?post=$link'>Ver mais</a></h4><br /><br />";
        }
    }
    
    public function encurta($texto, $tamPermitido) {
        return (strlen($texto) > $tamPermitido) ? substr($texto, 0, $tamPermitido).'...' : $texto;
    }
    public function connect(){
      global $pdo;
      $this->DB = $pdo;
    }
    
}
?>