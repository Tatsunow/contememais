<?php

  class User {
	  
	  
	  private $DB;
	  public function __construct()
	  {
	
		   $this->setaDB();
		  
	  }
	  
	 public function getFonte($usuario){
		  
		  $font = $this->retorno($usuario)->fonte;
		  $nome = $this->retorno($usuario)->nome;
		  if(empty($font)){
			  
			  $font = "$nome, http://www.contememais.com/me";
			  
		  }
		  return $font;
		  
	  }
	  
	  public function change($foto, $nome, $usu, $pass, $fonte){
		  
		  $senha = "";
		  if(empty($pass)){
			  $senha = $this->retorno($_SESSION['usuario'])->pass;
		  } else {
			  $senha = $this->geraHash($pass);
		  }
		  $usuario = $_SESSION['usuario'];
		  $sql = $this->DB->prepare("UPDATE `me_users` SET `nome`=?,`user`=?,`pass`=?,`foto`=?,`fonte`=? WHERE `user`=?");
		  $sql->bindParam(1, $nome);
		  $sql->bindParam(2, $usu);
		  $sql->bindParam(3, $senha);
		  $sql->bindParam(4, $foto);
		  $sql->bindParam(5, $fonte);
		  $sql->bindParam(6, $usuario);
		  $sql->execute();
		  $_SESSION['nome'] = $nome;
		  $_SESSION['usuario'] = $usu;
		  if(!empty($usu) && !($usu == $usuario)){
			  
			  $sql = $this->DB->prepare("UPDATE `me_posts` SET `Autor`=? WHERE `Autor`=?");
			  $sql->bindParam(1, $usu);
			  $sql->bindParam(2, $usuario);
			  $sql->execute();
			  
		  }
		  
	  }
	  
	  public function retorno($usuario){
		  
		  $sql = $this->DB->prepare("SELECT * FROM `me_users` WHERE `user`=?");
		  $sql->bindParam(1, $usuario);
		  $sql->execute();
		  return $sql->fetch();
		  
	  }
	  
	  public function logar($usuario, $senha){
		  
		  $pass = $this->geraHash($senha);
		  $sql = $this->DB->prepare("SELECT * FROM `me_users` WHERE `user`=? AND `pass`=?");
		  $sql->bindParam(1, $usuario);
		  $sql->bindparam(2, $pass);
		  $sql->execute();
		  if($sql->rowCount() >= 1){
			  
			  $nome = "";
			  while($dad=$sql->fetch()){
				  
				  $nome = $dad->nome;
				  
			  }
			  
			  $this->setaSessao($usuario, $nome);
			  header("Location: /me/admin/");
			  
		  } else {
			  
			  echo "Usuario ou senha incorretos!";
			  
		  }
		  
		  
		  
	  }
	  
	  public function geraHash($texto){
		  
		  $hash = hash("sha256", $texto);
		  
		  return $hash;
		  
	  }
	  
	  public function proteger(){
	
		  if(!$this->isLogged()){
			  
			  header("Location: /me/admin/login.php");
			  
			  
		  }   else {
			  
			  return;
			  
		  }
		  
		  
	  }
	  
	  
	  public function isLogged(){
		  
		  if($this->temSessao()){
			  
			  return true;
			  
		  } else {
			  
			  return false;
			  
		  }
		  
		  
	  }
	  
	  public function setaSessao($usuario, $nome){
		  
		  
		  $_SESSION['usuario'] = $usuario;
		  $_SESSION['nome'] = $nome;
		  
		  
	  }
	  
	  public function temSessao(){
	
		  if(isset($_SESSION['usuario'], $_SESSION['nome'])){
			  
			  return true;
			  
		  } else {
			  
			  return false;
			  
		  }
		  
		  
	  }
	  
	  
	  public function sair(){
	
		  if($this->isLogged()){
			  
			  unset($_SESSION['usuario']);
			  unset($_SESSION['nome']);
			  session_destroy();
			  header("Location: /me/admin/login.php");
			  
		  }
		  
	  }
	  
	  
	  
	  public function getName(){
	
		  if($this->isLogged() && isset($_SESSION['nome'], $_SESSION['usuario'])){
			  
			  return $_SESSION['nome'];
			  
		  }
		  
	  }
	  
	  
	  
	  private function setaDB()
	  {
	
		   global $pdo;
		  $this->DB = $pdo;
		  
		  
	  }
	  
	  
	  
	  
  }


?>