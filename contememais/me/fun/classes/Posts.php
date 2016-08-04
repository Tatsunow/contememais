<?php

  class Posts {
      
      private $DB;
      
      public function __construct(){
          
          global $pdo;
          $this->DB = $pdo;
          
      }
      
      public function post($id){
		  
		  $sql = $this->DB->prepare("SELECT * FROM `me_posts` WHERE `ID`=?");
		  $sql->bindParam(1, $id);
		  $sql->execute();
		  return $sql->fetch();
		  
		  
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
              preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i', $dad->Post, $fto);
              $tags = "";
              foreach($v as $row){
                  
                  $tags = $tags . "<a href='?module=post&tag=$row'>$row</a> ";
                  
              }
			  $ftostr = "";
			  if(isset($fto['src']) && !empty($fto['src'])) {
				  $src = $fto['src'];
				  $ftostr = "<a href='index.php?module=post&id=$id'><img class='thumb' src='$src'/></a><br />";
			  }
              ?>
              <a href='index.php?module=post&id=<?php echo $id; ?>'><?php echo $nome; ?></a><br />
              Autor: <?php echo $autor; ?> Tags: <?php echo $tags; ?><br />
              <?php echo $ftostr; ?>            
              <div class="fb-like" data-href="http://www.contememais.com/me/?module=post&id=<?php echo $id; ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
             <br /><br />
              
              <?php
              
              
              
          }
          
          
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
      
	  public function getResults($query, $where, $colum){
		  $sql = $this->DB->prepare("SELECT * FROM `$where` WHERE `$colum` LIKE '%$query%'");
		  $sql->execute();
		  $co = $sql->rowCount();
		  $str = "<h3>Postagens Encontradas: ($co)</h3>";
		  while($dad=$sql->fetch()){
			  
			 $id = $dad->ID;
			 $nome = $dad->Nome;
			 $autor = $dad->Autor;
			 $tags = $dad->Tags;
              $v = explode(",", $tags);
              $tags = "";
              foreach($v as $row){
                  
                  $tags = $tags . "<a href='?module=post&tag=$row'>$row</a> ";
                  
              }
			 $line = "<a href='index.php?module=post&id=$id'>$nome - Por $autor</a> Tags: $tags";
			 $str = $str . $line . "<br />";
			  
		  }
		  if($sql->rowCount() == 0){
			  $str = "<h3>Nenhuma Postagem Encontrada<h3>";
		  }
		  return $str;
		  
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
      
	  public function namebyuser($autor){
		  
		  $sql = $this->DB->prepare("SELECT * FROM `me_users` WHERE `user`=?");
		  $sql->bindParam(1, $autor);
		  $sql->execute();
		  $str;
		  while($dad=$sql->fetch()){
			  $str = $dad->nome;
		  }
		  return $str;
		  
	  }
	  
	  public function getfoto($autor){
		  
		  $sql = $this->DB->prepare("SELECT * FROM `me_users` WHERE `user`=?");
		  $sql->bindParam(1, $autor);
		  $sql->execute();
		  $str;
		  while($dad=$sql->fetch()){
			  
			  $str = $dad->foto;
			  
		  }
		  return $str;
		  
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
			  $foto = $this->getfoto($autor);
			  $nomedoautor = $this->namebyuser($autor);
              $v = explode(",", $tags);
              $tags = "";
			  $users = new User();
			  $fonte = $users->getFonte($autor);
              foreach($v as $row){
                  
                  $tags = $tags . "<a href='?module=post&tag=$row'>$row</a> ";
                  
              }
              ?>
              <h3><?php echo $nome; ?></h3>
              
              <?php echo $post?>
              <br /><br />
               Tags: <?php echo $tags; ?>
              <br /><br />
              
             <div class='postfooter'>
				  
					 <div class="fotob">
					 <img src="<?php echo $foto; ?>"/>
					 </div>
					 <span class="nome"><h4>Postagem feita por <?php echo $nomedoautor;?> (<?php echo $autor; ?>)</h4>
					 Fonte: <?php echo $fonte; ?>
					 </span>
					 
                 </div>
              <?php
              
          }
          if($sql->rowCount() == 0){
              
              echo "<h3>Post não encontrado</h3>";
              
          }
          
      }
      
      
  }

?>