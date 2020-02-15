<?php

  require_once("constant.php");
  require_once("checkip.php");

  header('Access-Control-Allow-Origin: *');

  $checkip = new CheckIp();

  if(isset($_GET[ISALIVE]))
  {    
    exit(STATE_TRUE);
  }

  $nickname = "";
  if(isset($_GET[NICKNAME])){
    $nickname = $_GET[NICKNAME];
    if (empty($nickname))
    {
      http_response_code(404);
      http_response_code(422);
      $value = NICKNAME;
      $message = "$value is missing.";
      exit($message);
    }
  }

  $activationCode = "";
  if(isset($_GET[NICKNAME])){
    $activationCode = $_GET[ACTIVATION_CODE];
    if (empty($activationCode))
    {
      http_response_code(404);
      http_response_code(422);
      $value = ACTIVATION_CODE;
      $message = "$value is missing.";
      exit($message);
    }
  }

  

?>