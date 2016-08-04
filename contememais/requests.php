<?php
require_once "app/init.php";
if(isset($_GET['request'])){
      $request = $_GET['request'];
      if($request == "likepost"){

          $id = $_GET['id'];
          
          $user = new Usuario();
          
          $post = new Post();
          
          $uuid = $user->getuuid(); 
          
          $post->like($id, $uuid);
          
          $likes = $post->getLikes($id);
          
          $who = $post->getWhoLiked($id);
          
          echo $likes . "," . $who;
      }
      if($request == "deletepost"){
          
          $id = $_GET['id'];
          
          $user = new Usuario();
          
          $post = new Post();
          
          $post->deletaPost($id);
          
          echo "true";
      }
      if($request == "foto"){
          
          $uuid = $_GET['uuid'];
          
          $user = new Usuario();
          
          echo $user->pegaImagem($uuid);
      }
      
      if($request == "share"){
          
          $id = $_GET['id'];
          
          $user = new Usuario();
          
          $post = new Post();
          
          $post->share($id);
          
          $email = $user->emailbyuuid($user->getuuid());
          
          $nome = $user->retorno($email)->nome . " " . $user->retorno($email)->sobrenome;
          
          echo $nome . ", Esta Pulicação foi compartilhada com sucesso.";
      }
      
      if($request == "login"){
          
          $email = $_GET['email'];
          
          $senha = $_GET['senha'];
          
          $user = new Usuario();
          
          $loga = $user->logarb($email, $senha);
          
          if($loga){
             echo "true";
          } else {
              echo "false";
          }
          
          
      }
    } else {
      header("Location: /");
   }