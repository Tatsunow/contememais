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
	  
	  private function db(){
		  
		  global $pdo;
		  $this->DB = $pdo;
		  return;
		  
	  }
	  
  }

?>