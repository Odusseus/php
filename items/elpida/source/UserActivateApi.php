<?php namespace Items;

  require_once("App.php");
  require_once("IpCheck.php");
  require_once("Constant.php");
  require_once("User.php");

  header('Access-Control-Allow-Origin: *');

  $ipCheck = new IpCheck();
  if(!$ipCheck->isGood){
    http_response_code(403);
    $message = "Forbidden, Ip is blacklisted.";
    exit($message);
  }

  if(isset($_GET[ISALIVE]))
  {    
    exit(STATE_TRUE);
  }

  $appname = "";
  if(isset($_GET[APPNAME])){
    $appname = $_GET[APPNAME];
    if(empty($appname)){
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

  $user = User::get($appname, $nickname);
  if(!$user->isSet()){
    http_response_code(404);
    $message = "User is not found.";
    exit($message);
  }

  if($user->activate($activationCode)){    
    http_response_code(200);
      $message = "Account is activated.";
      exit($message);
  } else {
    http_response_code(404);
      $value = ACTIVATION_CODE;
      $message = "{$value} not found.";
      exit($message);
  }
?>