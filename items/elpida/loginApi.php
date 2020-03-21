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

  //Receive the RAW post data.
  $content = trim(file_get_contents("php://input"));

  //Attempt to decode the incoming RAW post data from JSON.
  $decoded = json_decode($content, true);

  $appname = getJsonValue($decoded, APPNAME);
  if($appname == null){
    http_response_code(422);
    $value = APPNAME;
    $message = "{$value} is missing.";
    exit($message);
  } else {
    if(!App::check($appname)){
      http_response_code(404);
      $message = "{$appname} not found.";
      exit($message);
    }
  }

  $nickname = getJsonValue($decoded, NICKNAME);
  if($nickname == null){
    http_response_code(422);
    $value = NICKNAME;
    $message = "{$value} is missing.";
    exit($message);
  }

  $password = getJsonValue($decoded, PASSWORD);
  if($password == null){
    http_response_code(422);
    $value = PASSWORD;
    $message = "{$value} is missing.";
    exit($message);
  }

  $user = new User();
    $user->get($appname, $nickname);
    if(!$user->isSet()){
      http_response_code(404);
      $message = "User {$nickname} is not found.";
      exit($message);
    } 
    else if($user->checkHashPassword($password) == false){
      http_response_code(401);
      $message = "User {$nickname} is not authorized.";
      exit($message);
    }
    else
    {
      $login = new Login($appname, $nickname);
      $login->new();
      http_response_code(200);
      $value = $login->entity->cookie;
      setcookie(COOKIE, $value, time()+3600);
      $message = "User {$nickname} is loged in.";
      exit($message);
    }
?>