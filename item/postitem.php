<?php

require_once("constant.php");
require_once("item.php");

header('Access-Control-Allow-Origin: *');

$user = "";
$key = "";
$code = "";

if(isset($_POST[USER])){
  $user = $_POST[USER];
}
else
{
  echo "USER is missing";
  return;
}

if(isset($_POST[KEY])){
  $key = $_POST[KEY];
}
else
{
  echo "KEY is missing";
  return;
}

if(isset($_POSt[CODE])){
  $code = $_POST[CODE];
}
else
{
  echo "POST is missing";
  return;
}

?>