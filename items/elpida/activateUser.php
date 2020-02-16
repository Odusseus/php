<?php

  require_once("constant.php");
  require_once("checkip.php");
  require_once("user.php");

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
      http_response_code(422);
      $value = NICKNAME;
      $message = "$value is missing.";
      exit($message);
    }
  }

  $activationCode = "";
  if(isset($_GET[ACTIVATION_CODE])){
    $activationCode = $_GET[ACTIVATION_CODE];
    if (empty($activationCode))
    {
      http_response_code(422);
      $value = ACTIVATION_CODE;
      $message = "$value is missing.";
      exit($message);
    }
  }

  $userFilename = DATA_DIR."/".JSON_DIR."/{$nickname}.json";
  $json = file_get_contents($userFilename);
  $user = unserialize($json);
  if($user->activate($activationCode)){
    $json = serialize($user);
    $userFilename = DATA_DIR."/".JSON_DIR."/{$nickname}.json";
    file_put_contents($userFilename, $json, LOCK_EX);
    http_response_code(200);
      $message = "account is activated.";
      exit($message);
  }
?>