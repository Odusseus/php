<?php
  require_once("constant.php");
  require_once("checkip.php");
  require_once("user.php");
  require_once("abstract/state.php");
  require_once("maxId.php");
  require_once("PasswordStorage.php");
  
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
    $message = "Maximum users is reached.";
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

  //$passwordStorage = new PasswordStorage();
  //$hashPassword = $passwordStorage->create_hash($password);
  //if(!$passwordStorage->verify_password($password, $hashPassword)){
  //  http_response_code(422);
  //  $message = "Password encryption error. Sorry, try again or take contact with the administrator";
  //  exit($message);
  //}
$hashPassword = password_hash($password, PASSWORD_DEFAULT);


  $email = getJsonValue($decoded, EMAIL);
  if($email == null){
    http_response_code(422);
    $value = EMAIL;
    $message = "$value is missing.";
    exit($message);
  }

  $filename = DATA_DIR."/".JSON_DIR."/{$nickname}.json";
  if(file_exists($filename)){
    http_response_code(403);
    $message = "Create user {$nickname} is forbidden.";
    exit($message);
  }
  else
  {
    $user = new User();
    $user->set($nickname, $hashPassword, $email);
    $maxId->next();

    $link = "https://www.odusseus.org/php/elpida/activateUser.php?nickname={$user->entity->nickname}&activationcode={$user->entity->activationCode}";

    $to      = "{$email}";
    $subject = 'activate your account';
    $message = "svp click on the link to active your account." . "\r\n" . "{$link}";
    $headers = 'From: noreply@odusseus.org' . "\r\n" .
       'Reply-To: noreply@odusseus.org' . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
   
    if (DEBUG) {
      $dateTime = date("Y-m-d-His", time());
      $mailFilename = DATA_DIR."/".MAIL_DIR."/{$dateTime}.txt";
      $mailFile = fopen($mailFilename, "w") or die("Unable to open {$mailFile} file!");
      fwrite($mailFile, $headers);
      fwrite($mailFile, $to);
      fwrite($mailFile, $subject);
      fwrite($mailFile, $message);
      fclose($mailFile);
    }
    else
    {
      mail($to, $subject, $message, $headers);
    }
  }
?>