<?php
class Post {
 
  private $DB;
  private $user;
  public $admicon = "<img class='option' src='https://cdn0.iconfinder.com/data/icons/metro-style-people-svg-icons/48/Programmer-512.png'/>";
  public function __construct(){
      
      $this->conexaoDB();
      
      $this->usuario();
      
  }


    public function getBlogPosts(){

        $sql = $this->DB->prepare("SELECT * FROM `posts` ORDER BY `ID` DESC");
        $sql->execute();
        $user = $this->user;
        while($dad=$sql->fetch()){

            $post_nome = $dad->name;
            $author = $dad->autor;
            $post_content = $dad->conteudo;
            $post_content = strip_tags($post_content, false);
            $post_content = substr($post_content, 0, 200) . "...";
            $email = $user->emailbyuuid($author);
            $nome = $user->retorno($email)->nc;
            $id = $dad->ID;
            echo "<br /><a href='index.php?module=blog&viewpost=$id'><h4>$post_nome - Por $nome</h4></a>
            <br />
            $post_content<br /><br />";

        }

    }

    public function blogPost($nome, $conteudo, $uuid){

        $sql = $this->DB->prepare("INSERT INTO `posts`(`name`, `autor`, `conteudo`) VALUES (?,?,?)");
        $sql->bindParam(1, $nome);
        $sql->bindParam(2, $uuid);
        $sql->bindParam(3, $conteudo);
        $sql->execute();

    }


    public function deletaBlogPost($id){

        $sql = $this->DB->prepare("DELETE FROM `posts` WHERE `ID`=?");
        $sql->bindParam(1, $id);
        $sql->execute();

    }


    public function getBlogPost($id){

        $sql = $this->DB->prepare("SELECT * FROM `posts` WHERE `ID`=$id");
        $sql->execute();
        $user = $this->user;
        while($dad=$sql->fetch()){
            $post_nome = $dad->name;
            $author = $dad->autor;
            $post_content = $dad->conteudo;
            $email = $user->emailbyuuid($author);
            $nome = $user->retorno($email)->nc;
            $pl = $user->getProfileLink($email);
            $nome = "<a href='$pl'>$nome</a>";
            $id = $dad->ID;
            $opt = "";
            if($user->isAdmin()){

                $opt = "<a style='color: #ff252f; font-weight: bold;' href='index.php?module=blog&viewpost=$id&action=deletar'>Deletar</a><br />";
            }
            echo "<br /><a href='index.php?module=blog&viewpost=$id'><h4>$post_nome</a> - Por $nome</h4>
            $opt<br />
            $post_content<br /><br />";

        }


    }


  	public function getPosts() {
		$uniqueid = $this->user->getuuid();
		$sql = "SELECT * FROM `pubs` ORDER BY `ID` DESC";
		$mysql = $this->DB->prepare($sql);
		$mysql->execute();

                $array = $this->getCPFI();
                if($this->isFixed($this->getCurrentFixed())){
                $dataid = $array['id'];
                $datauuid = $array['uuid'];
                $datapost = $array['msg'];
                $datalikes = $this->getLikes($dataid);
                $email = $this->user->emailbyuuid($datauuid);
                $datauser = $this->user->retorno($email)->nome . " " . $this->user->retorno($email)->sobrenome;
                $datastatus = $this->user->retorno($email)->status;
                $co = $this->getComments($dataid);
                $foto = "";
		        if(file_exists("media/images/perfilImages/$datauuid.jpg")){
                $foto = "media/images/perfilImages/$datauuid.jpg";
                } else {
                if(!empty($this->user->getImagem($datauuid))){
                $foto = $this->user->getImagem($datauuid);
                } else {
                $foto = "media/images/perfilImages/default.png";
                   }
                 }
                $su = $this->user->getuuid();
                $delete = "";
                $datapost = $this->facesManager($datapost);
		if($this->haveVideo($datapost)){
			$value = $this->getVideoURL($datapost);
			$value = explode("/watch?v=", $value)[1];
			$value = "http://youtube.com/embed/" . $value;
			$datapost = str_replace("video=", '<iframe width="100%" height="400" src="' . $value . '" frameborder="0" allowfullscreen></iframe>', $datapost);
		}
		if(empty($datastatus)){
			$datastatus = "Este usuário não colocou um status.";
		        }        
                if($this->user->getuuid() == $datauuid || $this->user->isAdmin()){
		$delete = "<a onclick='deleta($dataid);'><img class='fechabtn' style='width: 13px;' src='http://www.euroinfocenter.ru/sites/default/files/cancel_exit_cross_close.png'/></a>";
                $fixa = "<a href='?desfixa=$dataid'><img title='desfixa' class='fechabtn' style='width: 13px;' src='http://freeiconbox.com/icon/256/34413.png'/></a>";
		}
                if(!$this->user->isAdmin()){
                 $fixa = "";
                }
        $like = "Curtir ($datalikes)";
        if($this->liked($dataid, $this->user->getuuid())){
        if($datalikes > 1){$like = "Descurtir ($datalikes Curtidas)";} else {$like = "Descurtir ($datalikes Curtida)";}
        }
        $tornadm = "";
        if($this->user->isAdmin()){
            $tornadm = "<a href='?setadmin=$datauuid'>" . $this->admicon . "</a>";
        }
        $wholikes = $this->getWhoLiked($dataid);
        $link = $this->user->getProfileLink($this->user->emailbyuuid($datauuid));
		$p1 = "<br /><div class='box box-simple' id='$dataid'>";
		$p2 = "<span class='post_nome'><a class='simple-tooltip' id='nomep' href='$link' title='<b>Status:</b> $datastatus'>$datauser</a></span><span class='options'>$delete  $fixa $tornadm</span>";
		$p3 = "<img data-target='$datauuid' id='profilephoto' class='thumbnail' style='width: 62px; height: 65px; line-height: 30px; margin-top: -50px; z-index: 2; clear: both;' src='$foto' title='$datauser'/><br /><br />";
		$p4 = "<span class='postmsg' style='width: 87%; height: 30%;'>$datapost</span><br /><br /><a class='simple-tooltip' onclick='like($dataid, event.target)' title='$wholikes' style='color: rgb(0, 139, 255);'>$like</a>&nbsp;&nbsp;<a id='share' class='blink' data-target='$uniqueid,$dataid'>Compartilhar</a>";
		$p5 = "<div class='post_co'>$co <div class='post_co_do'><form method='POST' action=''><input type='text' name='uuid' value='$su' hidden/><input type='text' name='id' value='$dataid' hidden/><input style='width: 74%; padding: 12px;' type='text' placeholder='Faça um comentario nesse post.' class='textfield' name='ct'/><input type='submit' class='btn btn-info' value='Comentar'/></form></div></div>";
		$p6 = "</div><br /><br /><br />";
		echo $p1 . $p2 . $p3 . $p4 . $p5 . $p6;
                }
		while($row=$mysql->fetch()){
                if($row->ID == $this->getCurrentFixed()) continue;
		$datauser = $this->user->retornouuid($row->uuid)->nome . " " . $this->user->retornouuid($row->uuid)->sobrenome;
		$datapost = $row->msg;
		if($this->haveVideo($datapost)){
			$value = $this->user->getVideoURL($datapost);
			$value = explode("/watch?v=", $value)[1];
			$value = "http://youtube.com/embed/" . $value;
			$datapost = str_replace("video=", '<iframe width="100%" height="400" src="' . $value . '" frameborder="0" allowfullscreen></iframe>', $datapost);
		}
		$datauuid = $row->uuid;
		$datastatus = $this->user->retorno($this->user->emailbyuuid($datauuid))->status;
		if(empty($datastatus)){
			$datastatus = "Este usuário não colocou um status.";
		}
		$dataid = $row->ID;
		$datalikes = $this->getLikes($dataid);
		$delete = "";
		$email = $this->user->emailbyuuid($this->user->getuuid());
		if($this->user->getuuid() == $datauuid || $this->user->isAdmin()){
		$delete = "<a onclick='deleta($dataid);'><img class='fechabtn' style='width: 13px;' src='http://www.euroinfocenter.ru/sites/default/files/cancel_exit_cross_close.png'/></a>";
        $fixa = "<a href='?fixa=$dataid'><img class='fechabtn' style='width: 13px;' src='http://freeiconbox.com/icon/256/34413.png'/></a>";
		}
                if(!$this->user->isAdmin()){
                 $fixa = "";
                }
		$datapost = $this->facesManager($datapost);
		$su = $this->user->getuuid();
		$co = $this->getComments($dataid);
		$foto = "";
		if(file_exists("media/images/perfilImages/$datauuid.jpg")){
        $foto = "media/images/perfilImages/$datauuid.jpg";
        } else {
        if(!empty($this->user->getImagem($datauuid))){
        $foto = $this->user->getImagem($datauuid);
        } else {
        $foto = "media/images/perfilImages/default.png";
        }
        }
        $like = "Curtir ($datalikes)";
        if($this->liked($dataid, $this->user->getuuid())){
        if($datalikes > 1){$like = "Descurtir ($datalikes Curtidas)";} else {$like = "Descurtir ($datalikes Curtida)";}
        }
        $tornadm = "";
        if($this->user->isAdmin()){
            $tornadm = "<a href='?setadmin=$datauuid'>" . $this->admicon . "</a>";
        }
        $wholikes = $this->getWhoLiked($dataid);
        $link = $this->user->getProfileLink($this->user->emailbyuuid($datauuid));
		$p1 = "<br /><div class='box box-simple' id='$dataid'>";
		$p2 = "<span class='post_nome'><a class='simple-tooltip' id='nomep' href='$link' title='<b>Status:</b> $datastatus'>$datauser</a> </span><span class='options'>$delete  $fixa $tornadm</span>";
		$p3 = "<img data-target='$datauuid' id='profilephoto' class='thumbnail' style='width: 60px; height: 65px; line-height: 30px; margin-top: -50px; z-index: 2; clear: both;' src='$foto' title='$datauser'/><br /><br />";
		$p4 = "<span class='postmsg' style='width: 87%; height: 30%;'>$datapost</span><br /><br /><a class='simple-tooltip' onclick='like($dataid, event.target)' title='$wholikes' style='color: rgb(0, 139, 255);'>$like</a>&nbsp;&nbsp;<a id='share' class='blink' data-target='$uniqueid,$dataid'>Compartilhar</a>";
		$p5 = "<div class='post_co'>$co <div class='post_co_do'><form method='POST' action=''><input type='text' name='uuid' value='$su' hidden/><input type='text' name='id' value='$dataid' hidden/><input style='width: 74%; padding: 12px;' type='text' placeholder='Faça um comentario nesse post.' class='textfield' name='ct'/><input type='submit' class='btn btn-info' value='Comentar'/></form></div></div>";
		$p6 = "</div><br /><br /><br />";
		echo $p1 . $p2 . $p3 . $p4 . $p5 . $p6;
		}
		
	}
  
  
  
   public function isFixed($id){

         $mysql = $this->DB->prepare("SELECT * FROM `pubs` WHERE `ID`=?");
         $mysql->bindParam(1, $id);
         $mysql->execute();
         $val = $mysql->fetch()->fixado;
         if($val == "sim"){
          return true;
         } else {
          return false;
          }

        }

    public function existPost($id){
    	$mysql = $this->DB->prepare("SELECT * FROM `pubs` WHERE `ID`=?");
    	$mysql->bindParam(1, $id);
    	$mysql->execute();
        $count = $mysql->rowCount();
        if($count > 0){
        	return true;
        }	 else {
        	return false;
        }
    }

   protected function setFixado($id, $fix){
     
    $mysql = $this->DB->prepare("UPDATE `pubs` SET `fixado`=? WHERE `ID`=?");
    $mysql->bindParam(1, $fix);
    $mysql->bindParam(2, $id);
    $mysql->execute();
 
    }
  public function haveVideo($text) {
		$ar = explode(" ", $text);
		foreach($ar as $str){
			return strpos($str, "video=") !== false;
		}
	}
	
	public function getVideoURL($text) {
		$ar = explode(" ", $text);
		foreach($ar as $str){
			$val = explode("video=", $str)[1];
			return $val;
		}
	}
	
	public function criaPost($msg) {
		$uuid = $this->user->getuuid();
		
		$mysql = $this->DB->prepare("INSERT INTO `pubs`(`uuid`, `msg`) VALUES (?,?)");
		
		$mysql->bindParam(1, $uuid);
		
		if(!$this->user->isAdmin()){
			$msg = strip_tags($msg, false);
		}
		$mysql->bindParam(2, $msg);
		
		$mysql->execute();
		
		$id;
		
		$mysql = $this->DB->prepare("SELECT * FROM `pubs` WHERE `uuid`=? AND `msg`=?");
		
		$mysql->bindParam(1, $uuid);
		$mysql->bindParam(2, $msg);
		$mysql->execute();
		
		$id = $mysql->fetch()->ID;
        return $id;
	}
	
	public function share($id){
	    $uuid = $this->user->getuuid();
	    
	    $mysql = $this->DB->prepare("SELECT * FROM `pubs` WHERE `ID`=?");
	    
	    $mysql->bindParam(1, $id);
	    
	    $mysql->execute();
	    
	    $f = $mysql->fetch();
	    
	    $puuid = $f->uuid;
	    $email = $this->user->emailbyuuid($puuid);
        $nome = $this->user->retorno($email)->nome . " " . $this->user->retorno($email)->sobrenome;
	    $pmsg = "<font style='color: #bbb; font-weight: bold;'>Compartilhado de: <a class='blink' href='perfil.php?uuid=$puuid'>" . $nome . "</a></font><br /><br /><br />" . $f->msg;
	    
	    $mysql = $this->DB->prepare("INSERT INTO `pubs`(`uuid`, `msg`) VALUES (?, ?)");
	    
	    $mysql->bindParam(1, $uuid);
	    $mysql->bindParam(2, $pmsg);
	    
	    $mysql->execute();
	}
	
	public function closecomment($id, $cuuid) {
		
		$mysql = $this->DB->prepare("DELETE FROM `comments` WHERE `ID`=:id AND `cuuid`=:cuuid");
		$mysql->bindParam(":id", $id);
		$mysql->bindParam(":cuuid", $cuuid);
		$mysql->execute();
	}
	public function getcmtuuid($cuuid){
		
		$mysql = $this->DB->prepare("SELECT * FROM `comments` WHERE `cuuid`=?");
		$mysql->bindParam(1, $cuuid);
		$mysql->execute();
		
		return $mysql->fetch()->uuid;
	}
	
	public function getComments($id) {
		
		$sql = "SELECT * FROM `comments` WHERE `ID`=? ORDER BY `ID` DESC";
		
		$mysql = $this->DB->prepare($sql);
		
		$mysql->bindParam(1, $id);
		
		$mysql->execute();
		
		$tr = "";
		
		while($row=$mysql->fetch()){
			$datamsg = $row->msg;
			$datamsg = $this->facesManager($datamsg);
			$datauuid = $row->uuid;
			$fName = $this->user->retorno($this->user->emailbyuuid($datauuid))->nome;
			$sName = $this->user->retorno($this->user->emailbyuuid($datauuid))->sobrenome;
			$datauser =  $fName . " " . $sName;
			$datacuuid = $row->cuuid;
			$dataid = $row->ID;
			$opt = "";
			$foto = "";
		    if(file_exists("media/images/perfilImages/$datauuid.jpg")){
            $foto = "media/images/perfilImages/$datauuid.jpg";
            } else {
            if(!empty($this->user->getImagem($datauuid))){
            $foto = $this->user->getImagem($datauuid);
            } else {
            $foto = "media/images/perfilImages/default.png";
            }
             }
			if($this->user->getuuid() == $datauuid || $this->user->isAdmin()){
				$opt = "<a href='?deletecmt=$datacuuid,$dataid'><img class='fechabtn' style='width: 13px;' src='http://www.euroinfocenter.ru/sites/default/files/cancel_exit_cross_close.png'/></a>";
			}
			$em = $this->user->emailbyuuid($datauuid);
			$link = $this->user->getProfileLink($em);
		$tr = $tr . "<div class='post_co_msg'><a class='plink' href='$link'><img src='$foto' style='width: 40px; float: left; margin-left: 5px;'/><br /><span class='plink' style='float: left; margin-top: -20px; margin-left: 10px; color: black;'>$datauser</span></a> <span style='margin-left: 10px;'>$datamsg</span><div class='alignright' style='margin-top: -17px;'>$opt</div></div>" . "<br />";
		}
		return "<div class='post_all'>" . $tr . "</div>";
	}
	
	public function comenta($id, $uuid, $msg) {
		
		if(!$this->user->isAdmin()){
			$msg = strip_tags($msg, false);
		}
		$mysql = $this->DB->prepare("INSERT INTO `comments`(`uuid`, `msg`, `ID`) VALUES (?,?,?)");
		$mysql->bindParam(1, $uuid);
		$mysql->bindParam(2, $msg);
		$mysql->bindParam(3, $id);
		$mysql->execute();
	}
	
  
  
  public function fixa($id){
     
    $this->setFixado($this->getCurrentFixed(), "nao");
    $this->setFixado($id, "sim");
     
    }

    public function desfixa() {
    
    $this->setFixado($this->getCurrentFixed(), "nao");
    }

   public function deletaPost($id) {
	    $uuid = $this->user->getuuid();
		if($this->user->isAdmin()){
	    $ms = $this->DB->prepare("DELETE FROM `pubs` WHERE `ID`=:id");
		$ms->bindParam(":id", $id);
		$ms->execute();
		$ms = $this->DB->prepare("DELETE FROM `comments` WHERE `ID`=:id");
		$ms->bindParam(":id", $id);
		$ms->execute();
		
	  } else {
	    if($this->existPost($id) && $this->user->isOwner($id, $uuid)){
	        
            $ms = $this->DB->prepare("DELETE FROM `pubs` WHERE `ID`=:id and `uuid`=:uuid");
	
		    $ms->bindParam(":id", $id);
		
		    $ms->bindParam(":uuid", $uuid);
		
		    $ms->execute(); 
			
			$ms = $this->DB->prepare("DELETE FROM `comments` WHERE `ID`=:id");
			
		    $ms->bindParam(":id", $id);
			
			$ms->execute();
	    
	    } else {
			$_SESSION['error'] = "Erro, ou o post que você tentou deletar não foi feito por você ou o post não existe. id= " . $id;
		
	  }
	  }
	}
	
   public function getWhoLiked($id){
		$mysql = $this->DB->prepare("SELECT * FROM `likes` WHERE `ID`=?");
		$mysql->bindParam(1, $id);
		$mysql->execute();
		$saida = "";
		while($row=$mysql->fetch()){
			$uuid = $row->uuid;
			$email = $this->user->emailbyuuid($uuid);
			$nome = $this->user->retorno($email)->nome . " " . $this->user->retorno($email)->sobrenome;
			$saida = $saida . '<a href="perfil.php?uuid=' . $uuid . '">' . $nome . "</a> Curtiu isso.<br />";
		}
		return $saida;
	}
	
	public function getCPFI(){
        $mysql = $this->DB->prepare("SELECT * FROM `pubs` WHERE `fixado`='sim'");
        $mysql->execute();
        $values = $mysql->fetch();
        $array = array('id' => $values->ID, 'msg' => $values->msg, 'uuid' => $values->uuid, 'likes' => $values->likes);
        return $array;
        }
	
	public function like($id, $uuid){

       if(!$this->liked($id, $uuid) && $uuid == $this->user->getuuid()){
       $mysql = $this->DB->prepare("INSERT INTO `likes`(`uuid`, `ID`) VALUES (?,?)");
       $mysql->bindParam(1, $uuid);
       $mysql->bindParam(2, $id);
       $mysql->execute();
      } else if($uuid == $this->user->getuuid()){
      	$mysql = $this->DB->prepare("DELETE FROM `likes` WHERE `ID`=? AND `uuid` = ?");
      	$mysql->bindParam(1, $id);
      	$mysql->bindParam(2, $uuid);
      	$mysql->execute();
      }
	}

	public function getLikes($id){

		$mysql = $this->DB->prepare("SELECT * FROM `likes` WHERE `ID`=?");
		$mysql->bindParam(1, $id);
		$mysql->execute();
		$count = $mysql->rowCount();
		return $count;
	}
	public function liked($id, $uuid){
     
        $mysql = $this->DB->prepare("SELECT * FROM `likes` WHERE `ID`=? AND `uuid`=?");
		$mysql->bindParam(1, $id);
		$mysql->bindParam(2, $uuid);
		$mysql->execute();
		$count = $mysql->rowCount();
		return $count != 0;
	}
	
    protected function getCurrentFixed(){
     
      $mysql = $this->DB->prepare("SELECT * FROM `pubs` WHERE `fixado`='sim'");
      $mysql->execute();
      return $mysql->fetch()->ID;
 
     }
  
    public function getSmiley($code) {
		
		return "<img draggable='false' src='media/images/emoticons/$code.PNG' style='width: 18px;'/>";
		
	}
	
	public function facesManager($input) {
		
		$output = $input;
		$output = str_replace("O:)", $this->getSmiley("anjo"), $output);
		$output = str_replace(":)", $this->getSmiley("sorriso"), $output);
		$output = str_replace(":D", $this->getSmiley("gargalhada"), $output);
		$output = str_replace("=D", $this->getSmiley("grandesorriso"), $output);
		$output = str_replace(":(", $this->getSmiley("triste"), $output);
		$output = str_replace(":P", $this->getSmiley("lingua"), $output);
		$output = str_replace(";)", $this->getSmiley("piscada"), $output);
		$output = str_replace(";D", $this->getSmiley("piscada02"), $output);
		$output = str_replace(":?", $this->getSmiley("dunderstand"), $output);
		$output = str_replace(":|", $this->getSmiley("semsorriso"), $output);
		$output = str_replace("(zzz)", $this->getSmiley("turmindo"), $output);
		$output = str_replace(":O", $this->getSmiley("surpreso"), $output);
		$output = str_replace(":(", $this->getSmiley("triste"), $output);
		$output = str_replace(";(", $this->getSmiley("chorando"), $output);
		$output = str_replace("(cool)", $this->getSmiley("legal"), $output);
		$output = str_replace(">_<", $this->getSmiley("raivoso"), $output);
		$output = str_replace(":*", $this->getSmiley("bjo"), $output);
		$output = str_replace(";*", $this->getSmiley("bjo"), $output);
		$output = str_replace("(sk)", $this->getSmiley("skol"), $output);
		$output = str_replace("<3", $this->getSmiley("heart"), $output);
		$output = str_replace("(m)", $this->getSmiley("soco"), $output);
		$output = str_replace("(beer)", $this->getSmiley("beer"), $output);
		$output = str_replace("(vergonha)", $this->getSmiley("seila"), $output);
		$output = str_replace("(demon)", $this->getSmiley("malicia"), $output);
		$output = str_replace("(medo)", $this->getSmiley("medo"), $output);
		return $output;
	}
  
  
  private function conexaoDB() {
      
        global $pdo;
        $this->DB = $pdo;
        
    }
    
  private function usuario(){
      
       $this->user = new Usuario();
       return;
  }
 
    
}
?>