<?php

 require_once("login.php");
 require_once("abstract/state.php");
 require_once("userEntity.php");

 class User {
   public $entity;  
  
   function set($appname, $nickname, $hashPassword, $email){
     $this->entity = new UserEntity();
     $this->entity->appname = $appname;
     $this->entity->nickname = $nickname;
     $this->entity->hashPassword = $hashPassword;
     $this->entity->email = $email;
     $this->entity->state = State::Newcomer;
     $this->entity->activationCode = rand(1000, 9999);
     $this->entity->activationCodeExpired = date("d-m-Y H:i:s", strtotime("+1 week"));
     $this->entity->createdTimestamp = date("d-m-Y H:i:s");

     $json = json_encode($this->entity);
     $userFilename = DATA_DIR."/".JSON_DIR."/{$appname}-{$nickname}.json";
     file_put_contents($userFilename, $json, LOCK_EX);
   }

   function get($appname, $nickname){
    $userFilename = DATA_DIR."/".JSON_DIR."/{$appname}-{$nickname}.json";
    if(file_exists($userFilename)){
      $json = file_get_contents($userFilename);
      $userEntity = json_decode($json);
      $this->entity = $userEntity;
    }
   }

   function isSet(){
     if(isset($this->entity)){
       return true;
     }
     return false;
   }

   function checkHashPassword($password){
     return password_verify ( $password , $this->entity->hashPassword );
   }

   function login(){
    $login = new Login($nickname);    
   }

   function activate($activationCode){
     if($this->entity->activationCode == $activationCode){
       $this->entity->state = State::Active;
       $json = json_encode($this->entity);
       $userFilename = DATA_DIR."/".JSON_DIR."/{$this->entity->appname}-{$this->entity->nickname}.json";
       file_put_contents($userFilename, $json, LOCK_EX);
       return true;
     }
     return false;
   }
 }
?>