<?php

require_once("cookieEntity.php");
date_default_timezone_set('Europe/Amsterdam');

class Cookie {
  public $entity;

  function get($cookie){
    $filename = $this->getFilename($cookie);
    if(file_exists($filename)){
      $json = file_get_contents($filename);
      $entity = json_decode($json);
      $this->entity = $entity;
    }
  }
  
  function getFilename($cookie){
    return $filename = DATA_DIR."/".JSON_DIR."/{$cookie}-cookie.json";
  }

  function set($appname, $nickname){
    $this->entity = new CookieEntity();
    $this->entity->appname = $appname;
    $this->entity->nickname = $nickname; 
    $this->entity->cookie = GUID(); 
    $this->entity->timestamp = date("d-m-Y H:i:s");

    $filename = $this->getFilename($this->entity->cookie);
    $json = json_encode($this->entity);
    file_put_contents($filename, $json, LOCK_EX);
  }

   function delete($cookie){
    $filename = $this->getFilename($cookie);
    if(file_exists($filename)){
      unlink($filename);
    }
   }

   function isSet(){
    if(isset($this->entity)){
      return true;
    }
    return false;
  }
}
?>