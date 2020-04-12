<?php namespace Elpida;
  require_once("code/State.php");
  require_once("code/Error.php");
  require_once("App.php");
  require_once("IpCheck.php");
  require_once("Constant.php");
  require_once("MaxId.php");
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
    http_response_code(200);
    exit(STATE_TRUE);
  }

  $userMaxId = new MaxId(MAX_CREATEUSER); 
  if($userMaxId->get() > 100){
    http_response_code(423);
    $value = NICKNAME;
    $message = "Maximum users is reached.";
    exit($message);
  };

  //Receive the RAW post data.
  $content = trim(file_get_contents("php://input"));

  //Attempt to decode the incoming RAW post data from JSON.
  $decoded = json_decode($content, true);

  $appname = Common::getJsonValue($decoded, APPNAME);
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

  $nickname = Common::getJsonValue($decoded, NICKNAME);
  if($nickname == null){
    http_response_code(422);
    $value = NICKNAME;
    $message = "{$value} is missing.";
    exit($message);
  }

  $password = Common::getJsonValue($decoded, PASSWORD);
  if($password == null){
    http_response_code(422);
    $value = PASSWORD;
    $message = "{$value} is missing.";
    exit($message);
  }

  $hashPassword = password_hash($password, PASSWORD_DEFAULT);

  $email = Common::getJsonValue($decoded, EMAIL);
  if($email == null){
    http_response_code(422);
    $value = EMAIL;
    $message = "{$value} is missing.";
    exit($message);
  }

  $filename = DATA_DIR."/".JSON_DIR."/{$appname}-{$nickname}.json";
  if(file_exists($filename)){
    http_response_code(403);
    $message = "Create user {$nickname} is forbidden.";
    exit($message);
  }
  else
  {
    $user = User::set($appname, $nickname, $hashPassword, $email);
    $maxId = new MaxId(MAX_CREATEUSER);
    $maxId->next();

    $link = "https://www.odusseus.org/php/elpida/userActivateApi.php?appname={$appname}&nickname={$nickname}&activationcode={$user->entity->activationCode}";

    $to      = "{$email}";
    $subject = 'activate your account';
    $message = "svp click on the link to actived your account." . "\r\n" . "{$link}";
    $headers = 'From: noreply@odusseus.org' . "\r\n" .
       'Reply-To: noreply@odusseus.org' . "\r\n" .
       'X-Mailer: PHP/' . phpversion();
   
    if (DEBUG) {
      $dateTime = date("Y-m-dTHis", time());
      $mailFilename = DATA_DIR."/".MAIL_DIR."/{$dateTime}.txt";
      $mailFile = fopen($mailFilename, "w") or die("Unable to open {$mailFile} file!");
      fwrite($mailFile, $headers);
      fwrite($mailFile, "\n");
      fwrite($mailFile, $to);
      fwrite($mailFile, "\n");
      fwrite($mailFile, $subject);
      fwrite($mailFile, "\n");
      fwrite($mailFile, $message);
      fclose($mailFile);
    }
    else
    {
      mail($to, $subject, $message, $headers);
    }
  }
?>