<?php
  require_once("constant.php");
  require_once("checkip.php");
  
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

  $nickName = getJsonValue($decoded, NICKNAME);
  if($nickName == null){
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

  $email = getJsonValue($decoded, EMAIL);
  if($email == null){
    http_response_code(422);
    $value = EMAIL;
    $message = "$value is missing.";
    exit($message);
  }

?>