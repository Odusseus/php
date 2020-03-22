<?php

  require_once("abstract/state.php");
  require_once("common.php");
  require_once("login.php");
  require_once("userEntity.php");

  class User {
    public $entity;  

    public function __construct() {
      // allocate your stuff
    }

    public static function set($appname, $nickname, $hashPassword, $email) {
      $instance = new self();
      $instance->save($appname, $nickname, $hashPassword, $email);
      return $instance;
    }
  
   function save($appname, $nickname, $hashPassword, $email){
     $this->entity = new UserEntity();
     $this->entity->appname = $appname;
     $this->entity->nickname = $nickname;
     $this->entity->hashPassword = $hashPassword;
     $this->entity->email = $email;
     $this->entity->state = State::Newcomer;
     $this->entity->activationCode = rand(1000, 9999);
     $this->entity->activationCodeExpired = date("d-m-Y H:i:s", strtotime("+1 week"));
     $this->entity->createdTimestamp = date("d-m-Y H:i:s");
     $this->entity->id = GUID();

     $json = json_encode($this->entity);
     $userFilename = $this->getFilename($appname, $nickname);
     file_put_contents($userFilename, $json, LOCK_EX);
   }

   function getFilename($appname, $nickname){
    return $filename = DATA_DIR."/".JSON_DIR."/{$appname}-{$nickname}.json";
  }

  public static function get($appname, $nickname) {
    $instance = new self();
    $instance->load($appname, $nickname);
    return $instance;
  }

   function load($appname, $nickname){
    $filename = $this->getFilename($appname, $nickname);
    if(file_exists($filename)){
      $json = file_get_contents($filename);
      $user = json_decode($json);
      $this->entity = $user;
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
       $userFilename = $this->getFilename($this->entity->appname, $this->entity->nickname);
       file_put_contents($userFilename, $json, LOCK_EX);
       return true;
     }
     return false;
   }
 }
?>