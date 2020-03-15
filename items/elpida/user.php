<?php

 require_once("login.php");
 require_once("abstract/state.php");
 require_once("userEntity.php");

 class User {
   public $entity;  
  
   function set($nickname, $hashPassword, $email){
     $this->entity = new UserEntity();
     $this->entity->nickname = $nickname;
     $this->entity->hashPassword = $hashPassword;
     $this->entity->email = $email;
     $this->entity->state = State::Newcomer;
     $this->entity->activationCode = rand(1000, 9999);
     $this->entity->activationCodeExpired = date("d-m-Y H:i:s", strtotime("+1 week"));
     $this->entity->createdTimestamp = date("d-m-Y H:i:s");

     $json = json_encode($this->entity);
     $userFilename = DATA_DIR."/".JSON_DIR."/{$this->entity->nickname}.json";
     file_put_contents($userFilename, $json, LOCK_EX);
   }

   function get($nickname){
    $userFilename = DATA_DIR."/".JSON_DIR."/{$nickname}.json";
    if(file_exists($userFilename)){
      $json = file_get_contents($userFilename);
      $userEntity = json_decode($json);
      $this->entity = $userEntity;
    }
   }

   function checkHashPassword($password){
     return password_verify ( $password , $this->entity->hashPassword );
      // if(isset($this->entity->hashPassword) and $this->entity->hashPassword == $hashPassword){
      //   return true;
      // }
      // return false;
   }

   function login(){

    $login = new Login($nickname);

    
   }

   function activate($activationCode){
     if($this->activationCode == $activationCode){
       $this->state = State::Active;
       return true;
     }
     return false;
   }
 }
?>