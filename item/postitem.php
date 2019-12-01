<?php

require_once("constant.php");
require_once("item.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();

$name = "";
$key = "";
$code = "";

if(isset($_POST[NAME]))
{
  $name = $_POST[NAME];
  $users = new Users();
  if(!$users->getName($name))
  {
    exit("Bad name ".$name);
  }
}
else
{
  exit("NAME is missing");
}

if(isset($_POST[VALUE]))
{
  $value = $_POST[VALUE];
}
else
{
  exit("VALUE is missing");
}

if(!isset($_POST[KEY]) and !isset($_POST[CODE]))
{
  $items = new Items();
  $item = new Item(null, null, $name);
  $items->add($item);
  $items->save();
  $item->saveValue($value);
  echo "{$item->key}:{$item->code}";

}
else
{
  if(isset($_POST[KEY])){
    $key = $_POST[KEY];
  }
  else
  {
    exit("KEY is missing");
  }
  
  if(isset($_POSt[CODE])){
    $code = $_POST[CODE];
  }
  else
  {
    exit("POST is missing");
  }
}



?>