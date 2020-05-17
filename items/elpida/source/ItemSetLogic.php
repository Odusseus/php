<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "Cookie.php";
require_once "HttpResponse.php";
require_once "Item.php";
require_once "User.php";

class ItemSetLogic
{
 public function getIsAlive()
 {
  return new HttpResponse(HttpCode::OK, STATE_TRUE);
 }

 public function setItem($cookieValue, $content)
 {
  if (empty($cookieValue)) {
   $value = COOKIE;
   $message = "Cookie $value is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $cookie = Cookie::get($cookieValue);
  if (empty($cookie)) {
   $message = "Cookie $cookieValue is not found.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $user = User::get($cookie->entity->appname, $cookie->entity->nickname);
  if (empty($user)) {
   $message = "User is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  //Attempt to decode the incoming RAW post data from JSON.
  $decoded = json_decode($content, true);

  $value = "";
  if (isset($decoded[VALUE])) {
   $value = $decoded[VALUE];

   if (!Common::checkMaxLength($value)) {
    $maxByte = MAX_BYTE;
    $valueLentgh = strlen($value);
    $message = "VALUE to long. Value({$valueLentgh}) > max value({$maxByte})";
    return new HttpResponse(HttpCode::NOT_ACCEPTABLE, $message);
   }
  } else {
   $value = VALUE;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $version = 0;
  if (isset($decoded[VERSION])) {
   $version = $decoded[VERSION];
  } else {
   $value = VERSION;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $item = Item::set($user->entity->id, $value, $version);
  if (!$item->isSet()) {
   $message = "Item is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  } else {
   $message = "Item is saved.";
   return new HttpResponse(HttpCode::OK, $message);
  }
 }
}
