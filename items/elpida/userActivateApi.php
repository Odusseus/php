<?php

  require_once("app.php");
  require_once("ipCheck.php");
  require_once("constant.php");
  require_once("user.php");

  header('Access-Control-Allow-Origin: *');

  $ipCheck = new IpCheck();

  if(isset($_GET[ISALIVE]))
  {    
    exit(STATE_TRUE);
  }

  $appname = "";
  if(isset($_GET[APPNAME])){
    $appname = $_GET[APPNAME];
    if($appname == null){
    http_response_code(422);
    $value = APPNAME;
    $message = "$value is missing.";
    exit($message);
    } else {
      if(!App::check($appname)){
        http_response_code(404);
        $message = "{$appname} not found.";
        exit($message);
      }
    }
  }

  $nickname = "";
  if(isset($_GET[NICKNAME])){
    $nickname = $_GET[NICKNAME];
    if (empty($nickname))
    {
      http_response_code(422);
      $value = NICKNAME;
      $message = "{$value} is missing.";
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
      $message = "{$value} is missing.";
      exit($message);
    }
  }

  $user = new User();
  $user->get($appname, $nickname);
  if(!$user->isSet()){
    http_response_code(404);
    $message = "{$appname} and {$nickname} are not found.";
    exit($message);
  }

  if($user->activate($activationCode)){    
    http_response_code(200);
      $message = "account is activated.";
      exit($message);
  } else {
    http_response_code(404);
      $value = ACTIVATION_CODE;
      $message = "{$value} not found.";
      exit($message);
  }
?>