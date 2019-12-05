<?php

ini_set('display_errors', 1);

require_once("constant.php");
require_once("user.php");
require_once("checkip.php");

header('Access-Control-Allow-Origin: *');

$checkip = new CheckIp();

if(isset($_POST[ISALIVE]) and filter_var($_POST[ISALIVE], FILTER_VALIDATE_BOOLEAN))
{
    exit(TRUE);
}

$checkKey = "";

if(!empty($_POST[KEY])){
  $checkKey = $_POST[KEY];
}
else
{
  http_response_code(404);
  exit("KEY is missing.");
}

if($checkKey != CHECKKEY){
  $checkip->addBadIp();
  http_response_code(401);
  exit("Bad is key.");
}

$userKey = "";
if(isset($_POST[USER])){
  $userKey = $_POST[USER];
}
else
{
  http_response_code(404);
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