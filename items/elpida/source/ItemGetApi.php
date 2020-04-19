<?php namespace Items;
  require_once("Constant.php");
  require_once("Cookie.php");
  require_once("Item.php");
  require_once("User.php");

  header('Access-Control-Allow-Origin: *');

  if(isset($_GET[ISALIVE]) and filter_var($_GET[ISALIVE], FILTER_VALIDATE_BOOLEAN))
  {
    http_response_code(200);      
    exit(STATE_TRUE);
  }

  if(isset($_GET[MAX_LENGTH]))
  {
    $value = MAX_BYTE;
      exit("{$value} bytes");
  } 
  
  $cookieValue = "";
  if(!isset($_COOKIE[COOKIE])) {
    http_response_code(400);
    $value = COOKIE;
    $message = "Cookie $value is missing.";
    return ($message);
  } else {
    $cookieValue = $_COOKIE[COOKIE];
  }
  
  $cookie = Cookie::get($cookieValue);
  if(!$cookie->isSet()){
    http_response_code(422);
    $value = COOKIE;
    $message = "Cookie {$value} is missing.";
    exit($message);
  }
    
  $user = User::get($cookie->entity->appname, $cookie->entity->nickname);

  $item = Item::get($user->entity->id);
  if(!$item->isSet())
  {
    http_response_code(500);
    $message = "Item is missing.";
    exit($message);
  }
  else
  {
    $itemGetRespons = $item->getJsonGetRespons();

    if(isset($_GET[ITEMLENGTH]))
    {
      http_response_code(200);      
      $length = strlen($itemGetRespons);
      $percent = 0;
      if($length > 0 && MAX_BYTE > 0)
      {
        $percent = ($length / MAX_BYTE) * 100;
      }

      $message = "{$length} bytes, {$percent}%.";

        exit($message);
    }
    else
    {
      http_response_code(200);      
      exit ($itemGetRespons);
    }
  }
?>