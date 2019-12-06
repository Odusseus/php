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
  else
  {
    http_response_code(404);
    die("No KEY found.");
  }
  
  $user = "";
  if(isset($_GET[USER])){
    $user = $_GET[USER];
    if (empty($user))
    {
      http_response_code(404);
      die("USER empty.");
    }
  }
  else
  {
    http_response_code(404);
    die("No USER found.");
  }
  
  $items = Items::new();
  $item = $items->getKey($key);
  if($item == NULL)
  {
    http_response_code(404);
    die();
  }
  else
  {
    $tokenGetRespons = $item->GetTokenGetRespons();
    exit ($tokenGetRespons);
  }
?>