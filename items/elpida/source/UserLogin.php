<?php namespace Items;

require_once("UserLoginEntity.php");
require_once("Cookie.php");
require_once("Common.php");
require_once "Constant.php";

class UserLogin {
  public $entity;

  public function __construct() {
    // allocate your stuff
  }

  function isSet() {
    if (isset($this->entity)) {
     return true;
    }
    return false;
   }

  public static function get($appname, $nickname) {
    $instance = new self();    
    $instance->load($appname, $nickname);
    return $instance;
  }

  public static function set($appname, $nickname) {
    $instance = new self();    
    $instance->load($appname, $nickname);
    $instance->save($appname, $nickname);
    return $instance;
  }
  
  function getFilename($appname, $nickname){
    return $filename = DATA_DIR."/".JSON_DIR."/{$appname}-{$nickname}-login.json";
  }

  function load($appname, $nickname){
    $filename = $this->getFilename($appname, $nickname);
    if(file_exists($filename)){
      $json = file_get_contents($filename);
      $entity = json_decode($json);
      $this->entity = $entity;
    }
  }

  function save($appname, $nickname){
    if(isset($this->entity) and isset($this->entity->cookie)){
      $cookie = Cookie::get($this->entity->cookie);
      if(isset($cookie)) {        
        $cookie->delete();
      }
    }

    $this->entity = new UserLoginEntity();
    $this->entity->appname = $appname;
    $this->entity->nickname = $nickname;
    $cookie = Cookie::set($this->entity->appname, $this->entity->nickname);
    $this->entity->cookie = $cookie->entity->cookie;
    
    $filename = $this->getFilename($this->entity->appname, $this->entity->nickname);
    $json = json_encode($this->entity, JSON_FORCE_OBJECT);
    file_put_contents($filename, $json, LOCK_EX);
   }
}



?>