<?php

require_once("constant.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();

$checkKey = "";
$userKey = "";

if(!empty($_POST[KEY])){
  $checkKey = $_POST[KEY];
}
else
{
  echo "KEY is missing";
  return;
}

if($checkKey != CHECKKEY){
  $checkip->addBadIp();
  echo "Bacon!";
  return;
}

if(isset($_POST[NAME])){
  $userKey = $_POST[NAME];
}
else
{
  echo "NAME is missing";
  return;
}

$users = new Users();
if(!$users->getKey($userKey))
{
  $user = new User($userKey);
  $users->add($user);
}
return;
?>