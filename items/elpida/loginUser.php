<?php
  require_once("constant.php");
  require_once("checkip.php");  
  require_once("PasswordStorage.php");
  require_once("user.php");
  
  header('Access-Control-Allow-Origin: *');

  $checkip = new CheckIp();

  if(isset($_GET[ISALIVE]))
  {    
    exit(STATE_TRUE);
  }

  //Receive the RAW post data.
  $content = trim(file_get_contents("php://input"));

  //Attempt to decode the incoming RAW post data from JSON.
  $decoded = json_decode($content, true);

  $nickname = getJsonValue($decoded, NICKNAME);
  if($nickname == null){
    http_response_code(422);
    $value = NICKNAME;
    $message = "$value is missing.";
    exit($message);
  }

  $password = getJsonValue($decoded, PASSWORD);
  if($password == null){
    http_response_code(422);
    $value = PASSWORD;
    $message = "$value is missing.";
    exit($message);
  }
  $passwordStorage = new PasswordStorage();
  $hashPassword = $passwordStorage->create_hash($password);
  
  $loginFilename = DATA_DIR."/".JSON_DIR."/{$nickname}Login.json";
  if(!file_exists($loginFilename)){
    http_response_code(404);
    $message = "User {$nickname} is not found.";
    exit($message);
  }
  else
  {
    $user = new User();
    $user->get($nickname);
    
    if($user->checkHashPassword($hashPassword)){
      http_response_code(401);
      $message = "User {$nickname} is not authorized.";
      exit($message);
    }
    else
    {
      http_response_code(200);
      $message = "User {$nickname} is loged in.";
      exit($message);
    }
  }
?>