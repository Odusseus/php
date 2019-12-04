<?php

require_once("constant.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();

$checkKey = "";

if(!empty($_POST[KEY])){
  $checkKey = $_POST[KEY];
}
else
{
  exit("KEY is missing.");
}

if($checkKey != CHECKKEY){
  $checkip->addBadIp();
  exit("Bad is key.");
}

$userKey = "";
if(isset($_POST[USER])){
  $userKey = $_POST[USER];
}
else
{
  exit("USER is missing.");
}

$users = Users::new();
if(!$users->getKey($userKey))
{
  $user = new User($userKey);
  $users->add($user);
}
return;
?>