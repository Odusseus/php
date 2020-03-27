<?php namespace Elpida;

require_once("LoginEntity.php");
require_once("Cookie.php");
require_once("Common.php");

class Login {
  public $entity;

  public function __construct() {
    // allocate your stuff
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
      $cookie->Cookie::delete($this->entity->cookie);
    }

    $this->entity = new LoginEntity();
    $this->entity->appname = $appname;
    $this->entity->nickname = $nickname;
    $cookie = Cookie::set($this->entity->appname, $this->entity->nickname);
    $this->entity->cookie = $cookie->entity->cookie;
    
    $filename = $this->getFilename($this->entity->appname, $this->entity->nickname);
    $json = json_encode($this->entity);
    file_put_contents($filename, $json, LOCK_EX);
   }
}



?>