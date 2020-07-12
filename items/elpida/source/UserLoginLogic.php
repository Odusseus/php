<?php namespace Items;

require_once "enum/State.php";
require_once "enum/Error.php";
require_once "enum/HttpCode.php";
require_once "App.php";
require_once "IpCheck.php";
require_once "Constant.php";
require_once "HttpResponse.php";
require_once "User.php";

class UserLoginLogic
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

 public function checkPassword($password)
 {
  if (empty($password)) {
   $value = PASSWORD;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }
  return new HttpResponse(HttpCode::OK, SUCCESS);
 }

 public function loginUser($content)
 {
  //Attempt to decode the incoming RAW post data from JSON.
  $decoded = json_decode($content, true);

  $appname = Common::getJsonValue($decoded, APPNAME);
  $httpResponse = $this->checkAppname($appname);
  if ($httpResponse->statusCode != HttpCode::OK) {
   return $httpResponse;
  }

  $nickname = Common::getJsonValue($decoded, NICKNAME);
  $httpResponse = $this->checkNickname($nickname);
  if ($httpResponse->statusCode != HttpCode::OK) {
   return $httpResponse;
  }

  $password = Common::getJsonValue($decoded, PASSWORD);
  $httpResponse = $this->checkPassword($password);
  if ($httpResponse->statusCode != HttpCode::OK) {
   return $httpResponse;
  }

  $user = User::get($appname, $nickname);
  if(!$user->checkHashPassword($password)){
    $message = "Combination {$appname}/{$nickname} not found.";
    return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }
  
  $userLogin = UserLogin::set($appname, $nickname);

  $cookie = $userLogin->entity->cookie;
  $isCookiePermanent = Common::getJsonValue($decoded, IS_COOKIE_PERMANENT);

  if($isCookiePermanent) {
    $cookieTimeout = COOKIE_PERMANENT;
  }
  else {
    $cookieTimeout = COOKIE_TIMEOUT;
  }
  
  setcookie(COOKIE, $cookie, time() + $cookieTimeout);

  $message = "User is loged in.";
  return new HttpResponse(HttpCode::OK, $message);
 }
}
