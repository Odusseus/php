<?php namespace Elpida;
  require_once("Constant.php");
  require_once("Cookie.php");
  require_once("Item.php");
  require_once("User.php");

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
  
  $cookie = Cookie::get($cookieValue);
  if(!$cookie->isSet()){
    http_response_code(422);
    $value = COOKIE;
    $message = "Cookie {$value} is missing.";
    exit($message);
  }
    
  $user = User::get($cookie->entity->appname, $cookie->entity->nickname);

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));
 
//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);

$value = "";
if(isset($decoded[VALUE]))
{
  $value = $decoded[VALUE];
}
else
{
  http_response_code(404);
  exit("VALUE is missing");
}

  $item = Item::set($user->entity->id, $value);
  if(!$item->isSet())
  {
    http_response_code(500);
    $message = "Item is missing.";
    exit($message);
  }
  else
  {
    http_response_code(200);
  }
?>