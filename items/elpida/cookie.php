<?php

require_once("cookieEntity.php");
date_default_timezone_set('Europe/Amsterdam');

class Cookie {
  public $entity;

  function __construct($appname, $nickname, $cookie){
    $filename = DATA_DIR."/".JSON_DIR."/{$cookie}cookie.json";
    if(file_exists($filename)){
      $json = file_get_contents($filename);
      $entity = json_decode($json);
      $this->entity = $entity;
    }
    else
    {
      $this->entity = new CookieEntity();
      $this->entity->appname = $appname;
      $this->entity->nickname = $nickname; 
      $this->entity->cookie = $cookie; 
      $this->entity->timestamp = date("d-m-Y H:i:s");
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