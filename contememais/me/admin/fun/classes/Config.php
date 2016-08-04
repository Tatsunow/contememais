<?php

  class Config {
	  
	  private $DB;
	  public function __construct(){
		  
		  $this->db();
		  
	  }
	  
	  public function getPart($part){
		 
		  if($part == "inicio"){
			  
			  $sql = $this->DB->prepare("SELECT * FROM `me_config`");
			  $sql->execute();
			  $text = "";
			  while($dad=$sql->fetch()){
			  
				  $text = $dad->inicio;
				  
			  }
			  
			  return $text;
			  
		  } 
		  
		  if($part == "sobre"){
			  
			  $sql = $this->DB->prepare("SELECT * FROM `me_config`");
			  $sql->execute();
			  $text = "";
			  while($dad=$sql->fetch()){
				  
				  $text = $dad->sobre;
				  
			  }
			  
			  return $text;
			  
			  
		  }
		  
		  return null;
		  
	  }
	  
	  public function setPart($part, $value){
		  
		  if($part == "inicio"){
			  
			  $sql = $this->DB->prepare("UPDATE `me_config` SET `inicio`=? WHERE `ID`=1");
			  $sql->bindParam(1, $value);
			  $sql->execute();
			  return;
			  
		  
		  }
		  if($part == "sobre"){
			  
			  $sql = $this->DB->prepare("UPDATE `me_config` SET `sobre`=? WHERE `ID`=1");
			  $sql->bindParam(1, $value);
			  $sql->execute();
			  return;
			  
		  }
		  
		  
		  
		  
	  }
	  
	  private function db(){
		  
		  global $pdo;
		  $this->DB = $pdo;
		  return;
		  
	  }
	  
  }

?>