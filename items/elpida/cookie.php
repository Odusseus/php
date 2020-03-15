<?php

require_once("cookieEntity.php");

class Cookie {
  public $entity;

  function __construct($nickname, $cookie){
    $filename = DATA_DIR."/".JSON_DIR."/{$cookie}cookie.json";
    if(file_exists($filename)){
      $json = file_get_contents($filename);
      $entity = json_decode($json);
      $this->entity = $entity;
    }
    else
    {
      $this->entity = new CookieEntity();
      $this->entity->nickname = $nickname; 
      $this->entity->cookie = $cookie; 
    }
  }

  function new(){
    $filename = DATA_DIR."/".JSON_DIR."/{$this->entity->cookie}cookie.json";
    $json = json_encode($this->entity);
    file_put_contents($filename, $json, LOCK_EX);
   }

   function delete(){
    $filename = DATA_DIR."/".JSON_DIR."/{$this->entity->cookie}cookie.json";
    if(file_exists($filename)){
      unlink($filename);
    }
   }
}



?>