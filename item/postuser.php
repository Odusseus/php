<?php

require_once("constant.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();


$key = "";
$name = "";

if(isset($_POST[KEY])){
  $key = $_POST[KEY];
}
else
{
  echo "KEY is missing";
  return;
}

if($key != ADMINKEY){
  $checkip->addBadIp();
  echo "Bacon!";
  return;
}

if(isset($_POST[NAME])){
  $name = $_POST[NAME];
}
else
{
  echo "NAME is missing";
  return;
}

$users = new Users();
if(!$users->getName($name))
{
  $user = new User($name);
  $users->add($user);
  $users->save();
}
return;
?>