<?php

  class Posts {
      
      private $DB;
      
      public function __construct(){
          
          global $pdo;
          $this->DB = $pdo;
          
      }
      
      
      public function getPosts(){
          
          $sql = $this->DB->prepare("SELECT * FROM `me_posts` ORDER BY `ID` DESC");
          $sql->execute();
          
          while($dad=$sql->fetch()){
              
              $nome = $dad->Nome;
              $autor = $dad->Autor;
              $post = $dad->Post;
              $post = strip_tags($post, '<br /><br><img><a><b><p><code><textarea>');
              $id = $dad->ID;
              $tags = $dad->Tags;
              $v = explode(",", $tags);
              $tags = "";
              foreach($v as $row){
                  
                  $tags = $tags . "<a href='?module=post&tag=$row'>$row</a> ";
                  
              }
              ?>
              
              <a href='index.php?module=post&id=<?php echo $id; ?>'><?php echo $nome; ?></a><br />
              Autor: <?php echo $autor; ?> Tags: <?php echo $tags; ?><br /><br />
              
              <?php
              
              
              
          }
          
          
      }
      
	  public function postar($title, $content, $tags){
		  
		  $usu = $_SESSION['usuario'];
		  $sql = $this->DB->prepare("INSERT INTO `me_posts`(`Nome`, `Autor`, `Post`, `Tags`) VALUES (?,?,?,?)");
		  $sql->bindParam(1, $title);
		  $sql->bindParam(2, $usu);
		  $sql->bindParam(3, $content);
		  $sql->bindParam(4, $tags);
		  $sql->execute();
		  
		  
	  }
	  
	  public function getManageablePosts() {
		  
		  $sql = $this->DB->prepare("SELECT * FROM `me_posts` ORDER BY `ID` DESC");
		  $sql->execute();
		  while($dad=$sql->fetch())
		  {
			  
			  $nome = $dad->Nome;
              $autor = $dad->Autor;
              $post = strip_tags($dad->Post, false);
			  $id = $dad->ID;
			  echo "<a href='index.php?module=posts&id=$id'>$nome - Por: $autor</a><br />";
			  
			  
		  }
		  
		  
		  
		  
	  }
	  
	  public function postcount(){
		  
		  $sql = $this->DB->prepare("SELECT * FROM `me_posts`");
		  $sql->execute();
		  return $sql->rowCount();
		  
	  }
	  
	  public function edita($id, $title, $content, $tags){
		  
		  $sql = $this->DB->prepare("UPDATE `me_posts` SET `Nome`=?,`Post`=?,`Tags`=? WHERE `ID`=?");
		  $sql->bindParam(1, $title);
		  $sql->bindParam(2, $content);
		  $sql->bindParam(3, $tags);
		  $sql->bindParam(4, $id);
		  $sql->execute();
		  
		  
	  }
	  
	  public function deletar($id){
		  
		  $sql = $this->DB->prepare("DELETE FROM `me_posts` WHERE `ID`=?");
		  $sql->bindParam(1, $id);
		  $sql->execute();
		  
	  }
	  
	  public function post($id){
		  
		  $sql = $this->DB->prepare("SELECT * FROM `me_posts` WHERE `ID`=?");
		  $sql->bindParam(1, $id);
		  $sql->execute();
		  return $sql->fetch();
		  
		  
	  }
      public function getPostsByTag($tag){
          
          $sql = $this->DB->prepare("SELECT * FROM `me_posts` WHERE `Tags` LIKE '%$tag%'");
          $sql->execute();
          while($dad=$sql->fetch()){
              
             $nome = $dad->Nome;
              $autor = $dad->Autor;
              $post = $dad->Post;
              $post = strip_tags($post, '<br /><br><img><a><b><p><code><textarea>');
              $id = $dad->ID;
              $tags = $dad->Tags;
              $v = explode(",", $tags);
              $tags = "";
              foreach($v as $row){
                  
                  $tags = $tags . "<a href='?module=post&tag=$row'>$row</a> ";
                  
              }
              ?>
              
              <a href='index.php?module=post&id=<?php echo $id; ?>'><?php echo $nome; ?></a><br />
              Autor: <?php echo $autor; ?> Tags: <?php echo $tags; ?><br /><br />
              
              <?php
              
          }
          
          if($sql->rowCount() == 0){
              
              echo "<h3>Nenhum post encontrado nessa categoria<h3>";
              
          }
          
          
          
      }
      
      public function getPostName($id){
          
          $sql = $this->DB->prepare("SELECT * FROM `me_posts` WHERE `ID`=?");
          $sql->bindParam(1, $id);
          $sql->execute();
          $nome;
          while($dad=$sql->fetch()){
              
              $nome = $dad->Nome;
              
          }
          if($sql->rowCount() == 0){
              
              $nome = "Post não encontrado";
              
          }
          
          return $nome;
          
      }
      
      public function getPost($id){
          
          $sql = $this->DB->prepare("SELECT * FROM `me_posts` WHERE `ID`=?");
          $sql->bindParam(1, $id);
          $sql->execute();
          
          while($dad=$sql->fetch()){
              
              $nome = $dad->Nome;
              $autor = $dad->Autor;
              $post = $dad->Post;
			  $tags = $dad->Tags;
              $v = explode(",", $tags);
              $tags = "";
              foreach($v as $row){
                  
                  $tags = $tags . "<a href='?module=post&tag=$row'>$row</a> ";
                  
              }

              ?>
              <h3><?php echo $nome; ?></h3>
              
              <?php echo $post?>
              <br /><br />
              Tags: <?php echo $tags; ?>
              <br/><br />
              
              <?php
              if($autor == "Tatsunow"){
				  ?>
                 <div class='postfooter'>
				  
					 <div class="fotob">
					 <img src="https://scontent-lga.xx.fbcdn.net/hphotos-xap1/v/l/t1.0-9/11050321_1599542876929585_7590710784267401142_n.jpg?oh=fff92b6966db83e1ea8551f0ebbb20b4&oe=55AD72E0"/>
					 </div>
					 <span class="nome"><h4>Postagem feita por Thiago Dlugosz M. (Tatsunow)</h4>
					 Fonte: Thiago Tatsunow, http://www.contememais.com/me
					 </span>
					 
                 </div>
                 <?php
				  
			  }
              
          }
          if($sql->rowCount() == 0){
              
              echo "<h3>Post não encontrado</h3>";
              
          }
          
      }
      
      
  }

?>