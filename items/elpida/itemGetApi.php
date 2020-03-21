<?php
  require_once("constant.php");
  require_once("cookie.php");
  require_once("item.php");

  header('Access-Control-Allow-Origin: *');

  if(isset($_GET[ISALIVE]) and filter_var($_GET[ISALIVE], FILTER_VALIDATE_BOOLEAN))
  {
      exit(TRUETEXT);
  }
  
  $cookieValue = "";
  if(!isset($_COOKIE[COOKIE])) {
    http_response_code(400);
    $value = COOKIE;
    $message = "Cookie $value is missing.";
    exit($message);
  } else {
    $cookieValue = $_COOKIE[COOKIE];
  }
  
  $cookie = new Cookie();
  $cookie->get($cookieValue);
  if(!$cookie->isSet()){
    http_response_code(422);
    $value = COOKIE;
    $message = "Cookie {$value} is missing.";
    exit($message);
  }
    
  $item = new Item($cookie->entity->appname, $cookie->entity->nickname);
  // if(!$item->isSet())
  // {
  //   http_response_code(404);
  //   $message = "Item is missing.";
  //   exit($message);
  // }
  // else
  // {
    http_response_code(200);
    $itemGetRespons = $item->getJsonGetRespons();
    exit ($itemGetRespons);
  //}
?>