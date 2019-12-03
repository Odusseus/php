<?php

require_once("constant.php");
require_once("item.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();


$userKey = "";
if(isset($_POST[NAME]))
{
  $userKey = $_POST[NAME];
  $users = new Users();
  $user = $users->getKey($userKey);
  if(!$user)
  {
    exit("Bad name ".$userKey);
  }
}
else
{
  exit("NAME is missing");
}

$value = "";
if(isset($_POST[VALUE]))
{
  $value = $_POST[VALUE];
}
else
{
  exit("VALUE is missing");
}

if(!isset($_POST[KEY]) and !isset($_POST[TOKEN]))
{
  $users = new Users();
  $user = $users->getKey($userKey);        

  $items = new Items();
  $item = new Item(null, null, $user->id);
  $items->add($item);
  $item->saveValue($value);
  exit($item->getJsonPostRespons());
}
else
{
  $key = "";
  if(isset($_POST[KEY])){
    $key = $_POST[KEY];
  }
  else
  {
    exit("KEY is missing");
  }
  
  $token = "";
  if(isset($_POST[TOKEN])){
    $token = $_POST[TOKEN];
  }
  else
  {
    exit("TOKEN is missing");
  }

  $items = new Items();
  $item = $items->getItem($key, $token, $user->id);
  if(!$item){
    exit("No data found.");
  }

  $item->token = GUID();
  $item->saveValue($value);
  $items->save();
  exit($item->getJsonGetRespons());

}
?>