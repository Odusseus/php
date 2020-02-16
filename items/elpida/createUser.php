<?php
  require_once("constant.php");
  require_once("checkip.php");
  require_once("login.php");
  require_once("user.php");
  require_once("abstract/state.php");
  require_once("maxId.php");
  
  header('Access-Control-Allow-Origin: *');

  $checkip = new CheckIp();

  if(isset($_GET[ISALIVE]))
  {    
    exit(STATE_TRUE);
  }

  $maxId = new MaxId(MAX_CREATEUSER); 
  if($maxId->get() > 100){
    http_response_code(423);
    $value = NICKNAME;
    $message = "Maximum user reached.";
    exit($message);
  };

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
    $user = new User();
    $user->set($nickname, $password, $email);
    $json = serialize($user);
    $userFilename = DATA_DIR."/".JSON_DIR."/{$nickname}.json";
    file_put_contents($userFilename, $json, LOCK_EX);
    
    $login = new Login("{$nickname}.json");
    $json = serialize($login);
    file_put_contents($loginFilename, $json, LOCK_EX);
    $maxId->next();

    $link = "https://www.odusseus.org/php/elpida/activateUser.php?nickname={$user->nickname}&activationcode={$user->activationCode}";

    $to      = "{$email}";
    $subject = 'activate your account';
    $message = "svp click on the link to active your account." . "\r\n" . "{$link}";
    $headers = 'From: noreply@odusseus.org' . "\r\n" .
       'Reply-To: noreply@odusseus.org' . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
   
   mail($to, $subject, $message, $headers);
  }
?>