<?php

   class util {

	   // variaveis
	   private $DB;
	   
	   
	   // codigo main
	   public function __construct(){
		   
		   $this->conecta();
		   
	   }
	   
	   public function clear(){
	       
	       $sql = $this->DB->prepare("DELETE FROM `cejs_msg`");
	       $sql->execute();
	       
	       
	   }
	   // pega mensagens que esta no banco de dados
	   public function getMessages(){
		   
		   $mysql = $this->DB->prepare("SELECT * FROM `cejs_msg`");
		   
		   $mysql->execute();
		   $mstring;
		   while($dad=$mysql->fetch()){
			   
			   $nome = $dad->Nome;
			   $msg = $dad->Msg;
			   $msg = strip_tags($msg, false);
			   $format = "<h4>$nome</h4><span>$msg</span>";
			   $format_div = "<div class='mensagem'>$format</div>";
			   
			   $mstring = $mstring . $format_div;
			   
		   }
		   
		   return $mstring;
		   
	   }
	   
	   
	   // envia mensagem para pagina inicial no banco de dados
	   public function sendMessage($nome, $mensagem){
		   
		   $mensagem = strip_tags($mensagem, false);
		   $mysql = $this->DB->prepare("INSERT INTO `cejs_msg` (`Nome`, `Msg`) VALUES (?, ?)");
		   $mysql->bindParam(1, $nome);
		   $mysql->bindParam(2, $mensagem);
		   $mysql->execute();
		   return true;
		   
	   }
	   
	   // conecta ao banco de dados
	   public function conecta(){
		   
		   global $pdo;
		   $this->DB = $pdo;
		   
	   }
	   
   }


?>