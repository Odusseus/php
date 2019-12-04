<?php
  require_once("constant.php");
  require_once("item.php");
  require_once("user.php");

  header('Access-Control-Allow-Origin: *');

  $key = "";
  if(isset($_GET[KEY])){
    $key = $_GET[KEY];
  }
  
  $token = "";
  if(isset($_GET[TOKEN])){
    $token = $_GET[TOKEN];
  }

  $user = "";
  if(isset($_GET[USER])){
    $user = $_GET[USER];
  }

  if (empty($key) 
      or empty($token)
      or empty($user))
  {
    http_response_code(404);
    die();
  }

  $users = Users::new();
  $user = $users->getKey($user);
  
  $item = new Item($key, $token, $user->id);
  $itemGetRespons = $item->getJsonGetRespons();
  exit ($itemGetRespons);
?>