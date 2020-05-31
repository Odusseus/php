<?php namespace Items;

require_once("enum/State.php");
require_once("enum/Error.php");
require_once("enum/HttpCode.php");
require_once("App.php");
require_once("IpCheck.php");
require_once("Constant.php");
require_once("HttpResponse.php");
require_once("IdMax.php");
require_once("User.php");

class UserCreateLogic
{
 public function isIpCheck()
 {

  $ipCheck = new IpCheck();
  if (!$ipCheck->isGood) {
   $message = "Forbidden, Ip is blacklisted.";
   return new HttpResponse(HttpCode::FORBIDDEN, $message);
  } else {
   $message = SUCCESS;
   return new HttpResponse(HttpCode::OK, $message);
  }
 }

 public function getIsAlive()
 {
  return new HttpResponse(HttpCode::OK, STATE_TRUE);
 }

 public function isIdMaxCheck()
 {
  $userIdMax = new IdMax(MAX_CREATEUSER);
  if ($userIdMax->get() > 100) {
   $message = "Maximum users is reached.";
   return new HttpResponse(HttpCode::LOCKED, $message);
  };
  return new HttpResponse(HttpCode::OK, STATE_TRUE);
 }

 public function checkAppname($appname)
 {
  if (empty($appname)) {
   $value = APPNAME;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  } else {
   if (!App::check($appname)) {
    $message = "{$appname} not found.";
    return new HttpResponse(HttpCode::NOT_FOUND, $message);
   }
  }
  return new HttpResponse(HttpCode::OK, SUCCESS);
 }

 public function checkNickname($nickname)
 {
  if (empty($nickname)) {
   $value = NICKNAME;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }
  return new HttpResponse(HttpCode::OK, SUCCESS);
 }

 public function checkPassword($password)
 {
  if (empty($password)) {
   $value = PASSWORD;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }
  return new HttpResponse(HttpCode::OK, SUCCESS);
 }

 public function checkEmail($email)
 {
  if (empty($email)) {
   $value = EMAIL;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }
  return new HttpResponse(HttpCode::OK, SUCCESS);
 }

 public function createUser($content)
 {
  //Attempt to decode the incoming RAW post data from JSON.
  $decoded = json_decode($content, true);

  $appname = Common::getJsonValue($decoded, APPNAME);
  $httpResponse = $this->checkAppname($appname);
  if ($httpResponse->code != HttpCode::OK) {
   return $httpResponse;
  }

  $nickname = Common::getJsonValue($decoded, NICKNAME);
  $httpResponse = $this->checkNickname($nickname);
  if ($httpResponse->code != HttpCode::OK) {
   return $httpResponse;
  }

  $password = Common::getJsonValue($decoded, PASSWORD);
  $httpResponse = $this->checkPassword($password);
  if ($httpResponse->code != HttpCode::OK) {
   return $httpResponse;
  }

  $hashPassword = password_hash($password, PASSWORD_DEFAULT);

  $email = Common::getJsonValue($decoded, EMAIL);
  $httpResponse = $this->checkEmail($email);
  if ($httpResponse->code != HttpCode::OK) {
   return $httpResponse;
  }

  $filename = DATA_DIR . "/" . JSON_DIR . "/{$appname}-{$nickname}.json";
  if (file_exists($filename)) {
   $message = "User {$nickname} already exists.";
   return new HttpResponse(HttpCode::FORBIDDEN, $message);
  } else {
   $user = User::set($appname, $nickname, $hashPassword, $email);
   $idMax = new IdMax(MAX_CREATEUSER);
   $idMax->next();
   $host = HOST;
   $link = "{$host}/UserActivateApi.php?appname={$appname}&nickname={$nickname}&activationcode={$user->entity->activationCode}";

   $to = "{$email}";
   $subject = 'activate your account';
   $message = "svp click on the link to actived your account." . "\r\n" . "{$link}";
   $headers = 'From: noreply@odusseus.org' . "\r\n" .
   'Reply-To: noreply@odusseus.org' . "\r\n" .
   'X-Mailer: PHP/' . phpversion();

   if (DEBUG) {
    $dateTime = date("Y-m-dTHis", time());
    $mailFilename = DATA_DIR . "/" . MAIL_DIR . "/{$dateTime}.txt";
    $mailFile = fopen($mailFilename, "w") or die("Unable to open {$mailFile} file!");
    fwrite($mailFile, $headers);
    fwrite($mailFile, "\n");
    fwrite($mailFile, $to);
    fwrite($mailFile, "\n");
    fwrite($mailFile, $subject);
    fwrite($mailFile, "\n");
    fwrite($mailFile, $message);
    fclose($mailFile);
   } else {
    mail($to, $subject, $message, $headers);
   }
  }

  return new HttpResponse(HttpCode::OK, SUCCESS);
 }
}
