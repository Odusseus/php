<?php

require_once("constant.php");
require_once("item.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();

// $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
// if(strcasecmp($contentType, 'application/json') != 0){
//     throw new Exception('Content type must be: application/json');
// }
 
//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));
 
//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);

if(isset($_POST[ISALIVE]) and filter_var($_POST[ISALIVE], FILTER_VALIDATE_BOOLEAN))
{
    exit(TRUETEXT);
}

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

if((!isset($decoded[KEY])
     or empty($decoded[KEY]))
   and (!isset($decoded[TOKEN])
         or empty($decoded[TOKEN])))
{
  $userKey = "";
  if(isset($decoded[USER]))
  {
    $userKey = $decoded[USER];
    $users = Users::new();
    $user = $users->getKey($userKey);
    if(!$user)
    {
      http_response_code(404);
      exit("USER [".$userKey."] not found.");
    }
  }
  else
  {
    http_response_code(404);
    exit("USER is missing.");
  }

  $items = Items::new();
  $item = new Item(null, null, $user->id);
  $items->add($item);
  $item->saveValue($value);
  exit($item->getJsonPostRespons());
}
else
{
  $key = "";
  if(isset($decoded[KEY]) and !empty($decoded[KEY])){
    $key = $decoded[KEY];
  }
  else
  {
    http_response_code(404);
    exit("KEY is missing");
  }
  
  $token = "";
  if(isset($decoded[TOKEN]) and !empty($decoded[TOKEN])){
    $token = $decoded[TOKEN];
  }
  else
  {
    http_response_code(404);
    exit("TOKEN is missing");
  }

  $items = Items::new();
  $item = $items->getItem($key, $token);
  if(!$item){
    http_response_code(404);
    exit("No item found.");
  }

  $item->token = GUID();
  $items->save();
  $item->saveValue($value);
  exit($item->getJsonPostRespons());
}
?>