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
   return HttpResponse::builder(HttpCode::FORBIDDEN, $message);
  } else {
   $message = SUCCESS;
   return HttpResponse::builder(HttpCode::OK, $message);
  }
 }

 public function getIsAlive()
 {
  return HttpResponse::builder(HttpCode::OK, STATE_TRUE);
 }
 
 public function getIsLoggedIn($cookieValue)
 {
  if (empty($cookieValue)) {
    $value = COOKIE_TOKEN;
    $message = "Cookie $value is missing.";
    return HttpResponse::builder(HttpCode::NOT_FOUND, $message);
   }
 
   $cookie = Cookie::get($cookieValue);
   if(empty($cookie)) {
     $message = "Cookie $cookieValue is unauthorised.";    
     return HttpResponse::builder(HttpCode::UNAUTHORIZED, $message);
   }
   $user = User::get($cookie->entity->appname, $cookie->entity->nickname);
  if(!$user->isSet()) {
    $message = "User is missing.";
    return HttpResponse::builder(HttpCode::NOT_FOUND, $message);
  }
  return HttpResponse::builder(HttpCode::OK, STATE_TRUE);
 }

 public function checkAppname($appname)
 {
  if (empty($appname)) {
   $value = APPNAME;
   $message = "$value is missing.";
   return HttpResponse::builder(HttpCode::UNPROCESSABLE_ENTITY, $message);
  } else {
   if (!App::check($appname)) {
    $message = "{$appname} not found.";
    return HttpResponse::builder(HttpCode::NOT_FOUND, $message);
   }
  }
  return HttpResponse::builder(HttpCode::OK, SUCCESS);
 }

 public function checkNickname($nickname)
 {
  if (empty($nickname)) {
   $value = NICKNAME;
   $message = "$value is missing.";
   return HttpResponse::builder(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }
  return HttpResponse::builder(HttpCode::OK, SUCCESS);
 }

 public function checkPassword($password)
 {
  if (empty($password)) {
   $value = PASSWORD;
   $message = "$value is missing.";
   return HttpResponse::builder(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }
  return HttpResponse::builder(HttpCode::OK, SUCCESS);
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
    $message = "Combination {$nickname}:password not found.";
    return HttpResponse::builder(HttpCode::NOT_FOUND, $message);
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
  $cookieTime =  time() + $cookieTimeout;
  setcookie(COOKIE_TOKEN, $cookie, $cookieTime);

  $message = "User is logged in.";
  $tokenTimeoutSeconde =  strval($cookieTime);
  return HttpResponse::builderWithToken(HttpCode::OK, $message, $cookie, $tokenTimeoutSeconde);
 }
}
