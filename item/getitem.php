<?php
  require_once("constant.php");
  require_once("item.php");

  header('Access-Control-Allow-Origin: *');

  if(isset($_GET[ISALIVE]) and filter_var($_GET[ISALIVE], FILTER_VALIDATE_BOOLEAN))
  {
      exit(TRUETEXT);
  }

  $key = "";
  if(isset($_GET[KEY])){
    $key = $_GET[KEY];
    if (empty($key))
    {
      http_response_code(404);
      die("KEY empty.");
    }
  }
  
  $token = "";
  if(isset($_GET[TOKEN])){
    $token = $_GET[TOKEN];
    if (empty($token))
    {
      http_response_code(404);
      die("TOKEN empty.");
    }
  }
  
  $items = Items::new();
  $item = $items->getItem($key, $token);
  if($item == NULL)
  {
    http_response_code(404);
    die();
  }
  else
  {
    $itemGetRespons = $item->getJsonGetRespons();
    exit ($itemGetRespons);
  }
?>