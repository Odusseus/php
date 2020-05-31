<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "App.php";
require_once "IpCheck.php";
require_once "Constant.php";
require_once "HttpResponse.php";
require_once "User.php";

class UserActivateLogic
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

 public function checkActivationCode($activationCode)
 {
  if (empty($activationCode)) {
   $value = ACTIVATION_CODE;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }
  return new HttpResponse(HttpCode::OK, "");
 }

 public function activeUser($appname, $nickname, $activationCode)
 {

  $httpResponse = $this->checkAppname($appname);
  if ($httpResponse->code != HttpCode::OK) {
   return $httpResponse;
  }

  $httpResponse = $this->checkNickname($nickname);
  if ($httpResponse->code != HttpCode::OK) {
   return $httpResponse;
  }

  $httpResponse = $this->checkActivationCode($activationCode);
  if ($httpResponse->code != HttpCode::OK) {
   return $httpResponse;
  }

  $user = User::get($appname, $nickname);
  if (!$user->isSet()) {
   $message = "User is not found.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  if ($user->activate($activationCode)) {
   $message = "Account is activated.";
   return new HttpResponse(HttpCode::OK, $message);
  } else {
   $value = ACTIVATION_CODE;
   $message = "{$value} not found.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }
 }

}
