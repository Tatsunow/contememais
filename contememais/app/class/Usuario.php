<?php

class Usuario extends UUID {

    private $DB;

    public function __construct() {

        $this->conexaoDB();
    }

	
	
	public function getName(){
	    $uuid = $this->getuuid();
	    $email = $this->emailbyuuid($uuid);
	    $nome = $this->retorno($email)->nome;
	    $sobrenome = $this->retorno($email)->sobrenome;
	    $nc = $nome . " " . $sobrenome;
	    return $nc;
	}
	
	public function mudaNomePara($to){
	    
	    $nome = strip_tags($to, false);
	    $email = $this->emailbyuuid($this->getuuid());
	    $mysql = $this->DB->prepare("UPDATE `usuarios` SET `nome`=? WHERE `email`=?");
	    $mysql->bindParam(1, $nome);
	    $mysql->bindParam(2, $email);
	    $mysql->execute();
	    
	    $this->updateNC();
	    
	}
	
	public function mudaSobrenomePara($to){
	    
	    $nome = strip_tags($to, false);
	    $email = $this->emailbyuuid($this->getuuid());
	    $mysql = $this->DB->prepare("UPDATE `usuarios` SET `sobrenome`=? WHERE `email`=?");
	    $mysql->bindParam(1, $nome);
	    $mysql->bindParam(2, $email);
	    $mysql->execute();
	    
	    $this->updateNC();
	}
	
	public function getProfileLink($email){
	    $nick = $this->retorno($email)->nick;
	    $uuid = $this->retorno($email)->uuid;
	    $link;
	    if(!empty($nick)){
	        $link = "http://www.contememais.com/perfil.php?nick=$nick";
	    } else {
	        $link = "http://www.contememais.com/perfil.php?uuid=$uuid";
	    }
	    
	    return $link;
	}
	
	public function getNick(){
	    
	    $email = $this->emailbyuuid($this->getuuid());
	    return $this->retorno($email)->nick;
	}
	
	public function mudaNickPara($to){
	    
		if($this->isAdmin() && $this->nickexist($to)){
			$uuid = $this->descobrenick($to);
			$this->deletaNick($uuid);
		}
	    $nick = $to;
	    $nick = strip_tags($nick, false);
	    $email = $this->emailbyuuid($this->getuuid());
	    $mysql = $this->DB->prepare("UPDATE `usuarios` SET `nick`=? WHERE `email`=?");
	    $mysql->bindParam(1, $nick);
	    $mysql->bindParam(2, $email);
	    $mysql->execute();
	    
	}
	
	
	public function deletaNick($uuid){
		
		$sql = $this->DB->prepare("UPDATE `usuarios` SET `nick`='' WHERE `uuid`=?");
		$sql->bindParam(1, $uuid);
		$sql->execute();
		
	}
	
	public function descobrenick($nick){
		
		$sql = $this->DB->prepare("SELECT * FROM `usuarios` WHERE `nick`=?");
		$sql->bindParam(1, $nick);
		$sql->execute();
		
		$uuid = $sql->fetch()->uuid;
		return $uuid;
		
    }
	
	public function nickexist($nick){
    
		 $sql = $this->DB->prepare("SELECT * FROM `usuarios` WHERE `nick`=:nick");
		 $sql->bindParam(":nick", $nick);
		 $sql->execute();
		 $count = $sql->rowCount();
		 if($count >= 1){
			return true;
		 } else {
			 return false;
               }
	
	 }
	
	
	public function search($query){
	
	$mysql = $this->DB->prepare("SELECT * FROM `usuarios` WHERE `nc` LIKE '%$query%'");
	$mysql->execute();
	$result;
	if($mysql->rowCount() <= 0) {
	    $result = "Nenhum resultado encontrado!";
	}
	while($dad=$mysql->fetch()){
	    $nome = $dad->nome . " " . $dad->sobrenome;
	    $uid = $dad->uuid;
	    $status = $dad->status;
	    $foto = "";
        if(file_exists("media/images/perfilImages/$uid.jpg")){
        $foto = "media/images/perfilImages/$uid.jpg";
        } else {
        if(!empty($this->getImagem($uuid))){
       $foto = $this->getImagem($uuid);
       } else {
       $foto = "media/images/perfilImages/default.png";
        }
       }
	    if(empty($status))$status = "Sem Status...";
	    $email = $dad->email;
	    $link = $this->getProfileLink($email);
	    $result = $result . "<b><a href='$link' title='$nome'><img class='thumbnail' style='width: 50px; height: 50px;' src='$foto'/><br />$nome</a></b><br />Status: $status" . "<br /><br />";
	}
	$found = $mysql->rowCount();
	return "($found Resultados Encontrados)<br /><br />" . $result;
	}
	
	public function getuuid() {
		
      $email = $_SESSION['email'];
	  $uuid = $this->retorno($email)->uuid;
      return $uuid;
	  
	}
	
	
	public function inbox($msg, $to){
	
	$from = $this->getuuid();
	$mysql = $this->DB->prepare("INSERT INTO `inbox`(`uuid`, `msg`, `from`) VALUES (?,?,?)");
	
	$mysql->bindParam(1, $to);
	$mysql->bindParam(2, $msg);
	$mysql->bindParam(3, $from);
	
	$mysql->execute();
	    
	}
	
	
	public function messagescount($uuid) {

	
	$mysql = $this->DB->prepare("SELECT * FROM `inbox` WHERE `uuid`=?");
	$mysql->bindParam(1, $uuid);
	$mysql->execute();
	
	return $mysql->rowCount();
	}
	
	
	// pega mensagens do inbox do usuario
	public function messages($uuid) {

	
	$mysql = $this->DB->prepare("SELECT * FROM `inbox` WHERE `uuid`=?");
	$mysql->bindParam(1, $uuid);
	$mysql->execute();
	$msgs = "";
    while($c=$mysql->fetch()){
        $email = $this->emailbyuuid($c->from);
        $nome = $this->retorno($email)->nome . " " . $this->retorno($email)->sobrenome;
        $msgs = $msgs . "De: <b>$nome</b> <br />Mensagem:<b><br /> " . $c->msg . "</b><br /><br />";
    }
    return $msgs;
	}
	
	
	public function setaAdmin($uuid){
	    
	    $email = $this->emailbyuuid($uuid);
	    
	    $mysql = $this->DB->prepare("UPDATE `usuarios` SET `perm`=999 WHERE email=:email");
	    
	    $mysql->bindParam(":email", $email);
	    
	    $mysql->execute();
	    
	}
	public function changeStatus($email, $status) {
    	 
      $mysql = $this->DB->prepare("UPDATE `usuarios` SET `status`=:status WHERE email=:email");
	  
	  if(!$this->isAdmin()){
	  	$status = strip_tags($status, false);
	  }
	  $mysql->bindParam(":email", $email);
	  
	  $mysql->bindParam(":status", $status);
	  
	  $mysql->execute();
	 
	}
	
	
	public function isOwner($id, $uuid){
	
	$mysql = $this->DB->prepare("SELECT * FROM `pubs` WHERE `ID`=? AND `uuid`=?");
	
	$mysql->bindParam(1, $id);
	$mysql->bindParam(2, $uuid);
    $mysql->execute();
    $row = $mysql->rowCount();
    
    return $row != 0;
	}
	
	public function mudaSenha($senha) {
		
		$senha = $this->gerarHash($senha);
		
		$uuid = $this->getuuid();
		
		$mysql = $this->DB->prepare("UPDATE `usuarios` SET `senha` = :senha WHERE `uuid` = :uuid");
		
		$mysql->bindParam(":senha", $senha);
		
		$mysql->bindParam(":uuid", $uuid);
		
		$mysql->execute();
		
	}
	
	
	public function isAdmin() {
		$ret = $this->retorno($this->emailbyuuid($this->getuuid()))->perm;
		if($ret == "999"){
			return true;
		} else {
			return false;
		}
	}
	
	
	public function getImagem($uuid) {
		
		$mysql = $this->DB->prepare("SELECT * FROM `usuarios` WHERE `uuid`=?");
		$mysql->bindParam(1, $uuid);
		$mysql->execute();
		return $mysql->fetch()->foto;
	}
	
	public function mudaImagem($uuid, $foto) {
	
        $mysql = $this->DB->prepare("UPDATE FROM `usuarios` SET `foto`=? WHERE `uuid`=?");
        $mysql->bindParam(1, $foto);
        $mysql->bindParam(2, $uuid);
		
	}


        

    public function getAge($uuid){
        $date = date("Y");
        $nasc = explode("-", $this->retorno($this->emailbyuuid($uuid))->nascimento);
        $idade = "" . $nasc[0]-intval($date);
        $idade = str_replace("-", "", $idade);
        return $idade;
    }
    
    

	public function pegaImagem($uuid){
	    $foto = "";
	    if(file_exists("media/images/perfilImages/$uuid.jpg")){
                $foto = "media/images/perfilImages/$uuid.jpg";
                } else {
                if(!empty($this->getImagem($uuid))){
                $foto = $this->getImagem($uuid);
                } else {
                $foto = "media/images/perfilImages/default.png";
                   }
                 }
                 
       return $foto;
	}
	
	public function showinarea($text){
	    echo "<script>show('$text');</script>";
	}
	
	
	
    public function criarUsuario() {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            if ($this->checarUsuario($_POST['email'])) {
                $_SESSION['msg'] = '<div class="alert alert-danger">Este e-mail já está em uso.</div>';
                header('Location: /register.php');
                return false;
            }
            $uuid = UUID::v4();
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if (!$email) {
                $_SESSION['msg'] = '<div class="alert alert-success">Coloque um email valido.</div>';
                header('Location: /register.php');
                return false;
            }
            $nascimento = $_POST['ano'] . '-' . $_POST['mes'] . '-' . $_POST['dia'];
            $mysql = $this->DB->prepare("INSERT INTO usuarios (uuid, nome, sobrenome, nascimento, email, senha) VALUES(?,?,?,?,?,?)");
            $mysql->bindParam(1, $uuid);
            $mysql->bindParam(2, $_POST['firstname']);
            $mysql->bindParam(3, $_POST['lastname']);
            $mysql->bindParam(4, $nascimento);
            $mysql->bindParam(5, $email);
            $mysql->bindParam(6, $this->gerarHash($_POST['senha']));
            $mysql->execute();
            $_SESSION['msg'] = '<div class="alert alert-success">Usuario cadastrado com sucesso.</div>';
            $senha = $_POST['senha'];
			$this->logarb($email, $senha);
        }
    }

    public function updateNC(){
      
      $email = $this->emailbyuuid($this->getuuid());
      $nome = $this->retorno($email)->nome . " " . $this->retorno($email)->sobrenome;
      $sql = $this->DB->prepare("UPDATE `usuarios` SET `nc`=? WHERE `email`=?");
      $sql->bindParam(1, $nome);
      $sql->binDParam(2, $email);
      $sql->execute();  
      
    }
    
    public function emailbynick($nick) {
        $mysql = $this->DB->prepare("SELECT * FROM usuarios WHERE nick=:nick");
        $mysql->bindParam(":nick", $nick);
        $mysql->execute();
        return $mysql->fetch()->email;
    }

    public function emailbyuuid($uuid) {
        $mysql = $this->DB->prepare("SELECT * FROM usuarios WHERE uuid=:uuid");
        $mysql->bindParam(":uuid", $uuid);
        $mysql->execute();
        return $mysql->fetch()->email;
    }

    public function logar() {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $mysql = $this->DB->prepare("SELECT * FROM usuarios WHERE email=:email AND senha=:senha");
            $mysql->bindParam(':email', $_POST['email']);
            $mysql->bindParam(':senha', $this->gerarHash($_POST['senha']));
            $mysql->execute();
            if ($mysql->rowCount() == 1) {
                $_SESSION['email'] = $_POST['email'];
                $this->setarSessao($_POST['email'], $_POST['senha']);
                $email = $_POST['email'];
                $nome = $this->retorno($email)->nome . " " . $this->retorno($email)->sobrenome;
                $sql = $this->DB->prepare("UPDATE `usuarios` SET `nc`=? WHERE `email`=?");
                $sql->bindParam(1, $nome);
                $sql->binDParam(2, $email);
                $sql->execute();
                if(isset($_SESSION['bl'])){
					
					$bl = $_SESSION['bl'];
					header("Location: $bl");
					return;
					
				}
                header('Location: /');
            } else {
                $_SESSION['error'] = 'Email ou senha inserido está incorreto';
                header('Location: /login.php');
            }
        } elseif (isset($_SESSION['Conte-me_Mais']) && !empty($_SESSION['Conte-me_Mais'])) {
            if ($this->checarSessao($_SESSION['email'])) {
                if(isset($_SESSION['bl'])){
					
					$bl = $_SESSION['bl'];
					header("Location: $bl");
					return;
					
				}
            }
        }
    }

       public function logarb($email, $senha) {
            $hash = $this->gerarHash($senha);
            $mysql = $this->DB->prepare("SELECT * FROM usuarios WHERE email=:email AND senha=:senha");
            $mysql->bindParam(':email', $email);
            $mysql->bindParam(':senha', $hash);
            $mysql->execute();
            if ($mysql->rowCount() == 1) {
                $_SESSION['email'] = $email;
                $this->setarSessao($email, $senha);
                $nome = $this->retorno($email)->nome . " " . $this->retorno($email)->sobrenome;
                $sql = $this->DB->prepare("UPDATE `usuarios` SET `nc`=? WHERE `email`=?");
                $sql->bindParam(1, $nome);
                $sql->binDParam(2, $email);
                $sql->execute();
                return true;
            } else {
                return false;
            }
        } 
     
    public function deslogar() {
        $this->unsetSessao($_SESSION['email']);
        session_destroy();
        session_unset();
        header('Location: /signin.php');
    }

    public function protege() {
        if (!empty($_SESSION['Conte-me_Mais'])) {
            if ($this->checarSessao($_SESSION['email'])) {
                return true;
            } else {
				$url = $_SERVER['REQUEST_URI'];
			   $_SESSION['bl'] = $url;
                header("Location: /login.php");
                return false;
            }
        } else {
			$url = $_SERVER['REQUEST_URI'];
			$_SESSION['bl'] = $url;
            header("Location: /login.php");
            return false;
        }
    }

    public function checarSessao($email) {
        if (isset($_SESSION['Conte-me_Mais'])) {
            $sessionSalva = $this->retorno($email)->sessao;
            if ($_SESSION['Conte-me_Mais'] == $sessionSalva) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function retorno($email) {
        $mysql = $this->DB->prepare("SELECT * FROM usuarios WHERE email=:email");
        $mysql->bindParam(":email", $email);
        $mysql->execute();
        return $mysql->fetch();
    }
	
    public function retornouuid($uuid) {
		$mysql = $this->DB->prepare("SELECT * FROM usuarios WHERE uuid=:uuid");
        $mysql->bindParam(":uuid", $uuid);
        $mysql->execute();
        return $mysql->fetch();
	}
	
    protected function checarUsuario($email) {
        $mysql = $this->DB->prepare("SELECT * FROM usuarios WHERE email=:email");
        $mysql->bindParam(":email", $email);
        $mysql->execute();
        if ($mysql->rowCount() != 0) {
            return true;
        } else {
            return false;
        }
    }

    

    protected function setarSessao($email, $senha) {
        $hash = $this->gerarHash(md5($email . time() . $senha));
        $mysql = $this->DB->prepare("UPDATE usuarios SET sessao=? WHERE email=?");
        $mysql->bindParam(1, $hash);
        $mysql->bindParam(2, $email);
        if ($mysql->execute()) {
            $_SESSION['Conte-me_Mais'] = $hash;
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
	
    protected function unsetSessao($email) {
        $mysql = $this->DB->prepare("UPDATE usuarios SET sessao=NULL WHERE email=?");
        $mysql->bindParam(1, $email);
        if ($mysql->execute()) {
            unset($_SESSION['Conte-me_Mais']);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    private function gerarHash($hash) {
        $salt = md5("Conte-me mais! - Social Network, desenvolvedor: Tatsunow");
        $codifica = hash("sha512", md5(base64_encode(md5(base64_encode($salt . base64_encode($hash) . $salt)))));
        $codifica = hash("sha512", $codifica);
        return $codifica;
    }

    public function isLogged(){
       return isset($_SESSION['email']); 
    }
    
    private function conexaoDB() {
        global $pdo;
        $this->DB = $pdo;
    }

}