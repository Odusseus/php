<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "Cookie.php";
require_once "HttpResponse.php";
require_once "Item.php";
require_once "IpCheck.php";
require_once "User.php";

class ItemSetLogic
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

 public function setItem($cookieValue, $content)
 {
  if (empty($cookieValue)) {
   $value = COOKIE;
   $message = "Cookie $value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }

  $cookie = Cookie::get($cookieValue);
  if (empty($cookie)) {
   $message = "Cookie $cookieValue is unauthorised.";
   return new HttpResponse(HttpCode::UNAUTHORIZED, $message);
  }

  $user = User::get($cookie->entity->appname, $cookie->entity->nickname);
  if (!$user->isset()) {
   $message = "User is not found.";
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
    $message = "Item is to long. Value({$valueLentgh}) > max value({$maxByte})";
    return new HttpResponse(HttpCode::NOT_ACCEPTABLE, $message);
   }
  } else {
   $value = VALUE;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::UNPROCESSABLE_ENTITY, $message);
  }

  $version = 0;
  if (isset($decoded[VERSION])) {
   $version = $decoded[VERSION];
  } else {
   $value = VERSION;
   $message = "$value is missing.";
   return new HttpResponse(HttpCode::NOT_FOUND, $message);
  }

  $currentItem = Item::get($user->entity->id);
  if ($currentItem->isSet() and VERSION_CHECK_ENABLED and $currentItem->itemEntity->version > $version) {
   $message = "version $version is obsolete. Refresh your item.";
   return new HttpResponse(HttpCode::BAD_REQUEST, $message);
  }
  $version++;
  $item = Item::set($user->entity->id, $value, $version);
  if (!$item->isSet()) {
   $message = "Item is not saved.";
   return new HttpResponse(HttpCode::INTERNAL_SERVER_ERROR, $message);
  } else {
   $message = "Item is saved.";
   return new HttpResponse(HttpCode::OK, $message);
  }
 }
}
