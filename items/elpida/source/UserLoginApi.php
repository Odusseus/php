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

  //Receive the RAW post data.
  $content = trim(file_get_contents("php://input"));

  //Attempt to decode the incoming RAW post data from JSON.
  $decoded = json_decode($content, true);

  $appname = Common::getJsonValue($decoded, APPNAME);
  if(empty($appname)){
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

  $nickname = Common::getJsonValue($decoded, NICKNAME);
  if(empty($nickname)){
    http_response_code(422);
    $value = NICKNAME;
    $message = "{$value} is missing.";
    exit($message);
  }

  $password = Common::getJsonValue($decoded, PASSWORD);
  if(empty($password)){
    http_response_code(422);
    $value = PASSWORD;
    $message = "{$value} is missing.";
    exit($message);
  }

  $user = User::get($appname, $nickname);
  if(!$user->isSet()){
    http_response_code(404);
    $message = "User {$nickname} is not found.";
    exit($message);
  } 
  
  if($user->checkHashPassword($password) == false){
    http_response_code(401);
    $message = "User {$nickname} is not authorized.";
    exit($message);
  }
  
  $userLogin = UserLogin::set($appname, $nickname);
  $cookie = $userLogin->entity->cookie;
  setcookie(COOKIE, $cookie, time()+3600);
  $message = "User is loged in.";
  http_response_code(200);
  exit($message);

?>