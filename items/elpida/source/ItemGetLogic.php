<?php namespace Items;

require_once "HttpResponse.php";
require_once "Constant.php";
require_once "Item.php";
require_once "User.php";
require_once "enum/HttpCode.php";

class ItemGetLogic
{

 public function isAlive()
 {
  return new HttpResponse(HttpCode::OK, STATE_TRUE);
 }

 public function getMaxLength()
 {
  $value = MAX_BYTE;
  $message = "{$value} bytes";
  return new HttpResponse(HttpCode::OK, $message);
 }

 public function getItem($cookieValue)
 {
  if (empty($cookieValue)) {
   $value = COOKIE;
   $message = "Cookie $value is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $cookie = Cookie::get($cookieValue);
  $user = User::get($cookie->entity->appname, $cookie->entity->nickname);
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
  }
  $message = "{$length} bytes, {$percent}%.";
  return new HttpResponse(HttpCode::OK, $message);
 }
}
