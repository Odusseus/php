<?php namespace Elpida;

require_once("code/error.php");
require_once("Common.php");
require_once("CookieEntity.php");
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
  
  public static function set($appname, $nickname) {
    $instance = new self();
    $instance->save($appname, $nickname);
    return $instance;
  }
  
   public function delete() {
    if(isset($this->entity->cookie))
    {
      $filename = Cookie::getFilename($this->entity->cookie);
      if(file_exists($filename)){
        unlink($filename);
      }
    }
  }

  function load($cookie){
    $filename = Cookie::getFilename($cookie);
    if(file_exists($filename)){
      $json = file_get_contents($filename);
      $entity = json_decode($json);
      $this->entity = $entity;
    }
    else
    {
      error_log(Error::FileNotFound." {$filename}", 0);
    }
  }
  
  static function getFilename($cookie){
    return $filename = DATA_DIR."/".JSON_DIR."/{$cookie}-cookie.json";
  }

  function save($appname, $nickname){
    $this->entity = new CookieEntity();
    $this->entity->appname = $appname;
    $this->entity->nickname = $nickname; 
    $this->entity->cookie = Common::GUID(); 
    $this->entity->timestamp = date("d-m-Y H:i:s");

    $filename = Cookie::getFilename($this->entity->cookie);
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