<?php
  require_once("constant.php");
  require_once("checkip.php");
  require_once("login.php");
  require_once("user.php");
  require_once("abstract/state.php");
  
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

  $email = getJsonValue($decoded, EMAIL);
  if($email == null){
    http_response_code(422);
    $value = EMAIL;
    $message = "$value is missing.";
    exit($message);
  }

  $loginFilename = DATA_DIR."/".JSON_DIR."/{$nickname}Login.json";
  if(file_exists($loginFilename)){
    http_response_code(403);
    $message = "Create user {$nickname} is forbidden.";
    exit($message);
  }
  else
  {
    $user = new User($nickname, $password, $email);
    $json = json_encode($user);
    $userFilename = DATA_DIR."/".JSON_DIR."/{$nickname}.json";
    $userFile = fopen($userFilename, "w") or die("Unable to open file!");
    fwrite($userFile, $json);
    fclose($userFile);

    $login = new Login("{$nickname}.json");
    $json = json_encode($login);
    $loginFile = fopen($loginFilename, "w") or die("Unable to open file!");
    fwrite($loginFile, $json);
    fclose($loginFile);
  }
?>