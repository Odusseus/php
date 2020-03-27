<?php namespace Elpida;

require_once("common.php");
require_once("cookieEntity.php");
date_default_timezone_set('Europe/Amsterdam');

class Cookie {
  public $entity;

  public function __construct() {
    // allocate your stuff
  }

  public static function get($cookie) {
    $instance = new self();
    $instance->load($cookie);
    return $instance;
  }
  
  public static function delete() {
    $filename = $this->getFilename($cookie);
    if(file_exists($filename)){
      unlink($filename);
    }
  }

  public static function set($appname, $nickname) {
    $instance = new self();
    $instance->save($appname, $nickname);
    return $instance;
  }

  function load($cookie){
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

  function save($appname, $nickname){
    $this->entity = new CookieEntity();
    $this->entity->appname = $appname;
    $this->entity->nickname = $nickname; 
    $this->entity->cookie = GUID(); 
    $this->entity->timestamp = date("d-m-Y H:i:s");

    $filename = $this->getFilename($this->entity->cookie);
    $json = json_encode($this->entity);
    file_put_contents($filename, $json, LOCK_EX);
  }

   function isSet(){
    if(isset($this->entity)){
      return true;
    }
    return false;
  }
}
?>