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
  if(!$users->getKey($userKey))
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
  $items = new Items();
  $item = new Item(null, null, $userKey);
  $items->add($item);
  $item->saveValue($value);
  // echo $item->getJsonGetRespons();
  echo $item->getJsonPostRespons();
  
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
  if(isset($_POSt[TOKEN])){
    $token = $_POST[TOKEN];
  }
  else
  {
    exit("TOKEN is missing");
  }
}
?>