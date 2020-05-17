<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "HttpResponse.php";
require_once "Item.php";
require_once "User.php";

class ItemGetLogic
{

 public function getIsAlive()
 {
  return new HttpResponse(HttpCode::OK, STATE_TRUE);
 }

 public function getItem($cookieValue)
 {
  if (empty($cookieValue)) {
   $value = COOKIE;
   $message = "Cookie $value is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $cookie = Cookie::get($cookieValue);
  if(empty($cookie)) {
    $message = "Cookie $cookieValue is not found.";
    return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $user = User::get($cookie->entity->appname, $cookie->entity->nickname);
  if(!$user->isSet()) {
    $message = "User is missing.";
    return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }
  $item = Item::get($user->entity->id);
  if (!$item->isSet()) {
   $message = "Item is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $itemGetRespons = $item->getJsonGetRespons();
  return new HttpResponse(HttpCode::OK, $itemGetRespons);
 }

 public function getLength($item)
 {
  $length = strlen($item);
  $percent = 0;
  if ($length > 0 && MAX_BYTE > 0) {
   $percent = ($length / MAX_BYTE) * 100;
   $message = "{$length} bytes, {$percent}%.";
  }
  else {
    $message = "{$length} byte, {$percent}%.";
  }
  return new HttpResponse(HttpCode::OK, $message);
 }

 public function getMaxLength()
 {
  $value = MAX_BYTE;
  $message = "{$value} bytes.";
  return new HttpResponse(HttpCode::OK, $message);
 }

}
