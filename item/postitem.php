<?php

require_once("constant.php");
require_once("item.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();

if(isset($_POST[ISALIVE]) and filter_var($_POST[ISALIVE], FILTER_VALIDATE_BOOLEAN))
{
    exit(TRUE);
}

$value = "";
if(isset($_POST[VALUE]))
{
  $value = $_POST[VALUE];
}
else
{
  http_response_code(404);
  exit("VALUE is missing");
}

if((!isset($_POST[KEY])
     or empty($_POST[KEY]))
   and (!isset($_POST[TOKEN])
         or empty($_POST[TOKEN])))
{
  $userKey = "";
  if(isset($_POST[USER]))
  {
    $userKey = $_POST[USER];
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
  if(isset($_POST[KEY]) and !empty($_POST[KEY])){
    $key = $_POST[KEY];
  }
  else
  {
    http_response_code(404);
    exit("KEY is missing");
  }
  
  $token = "";
  if(isset($_POST[TOKEN]) and !empty($_POST[TOKEN])){
    $token = $_POST[TOKEN];
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