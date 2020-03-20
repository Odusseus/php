<?php

require_once("loginEntity.php");
require_once("cookie.php");
require_once("common.php");

class Login {
  public $entity;

  function __construct($appname, $nickname){
    $filename = DATA_DIR."/".JSON_DIR."/{$appname}-{$nickname}login.json";
    if(file_exists($filename)){
      $json = file_get_contents($filename);
      $entity = json_decode($json);
      $this->entity = $entity;
    }
    else
    {
      $this->entity = new loginEntity();
      $this->entity->appname = $appname;
      $this->entity->nickname = $nickname;
      $this->entity->cookie = Null;        
    }
  }

  function new(){
    if(isset($this->entity->cookie)){
      $cookie = new Cookie($this->entity->appname, $this->entity->nickname, $this->entity->cookie);
      $cookie->delete();
    }
    $this->entity->cookie = GUID();
    $filename = DATA_DIR."/".JSON_DIR."/{$this->entity->appname}-{$this->entity->nickname}login.json";
    $json = json_encode($this->entity);
    file_put_contents($filename, $json, LOCK_EX);

    $cookie = new Cookie($this->entity->appname, $this->entity->nickname, $this->entity->cookie);
    $cookie->new();
   }
}



?>