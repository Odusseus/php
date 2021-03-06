<?php namespace Items;

require_once("Environment.php");
require_once("Constant.php");
require_once("enum/HttpCode.php");

class Common
{

 public static function getJsonValue($decoded, $valueName)
 {
  if (isset($decoded[$valueName])) {
   return $decoded[$valueName];
  }
  return NULL;
 }

 // https://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
 public static function getClientIp()
 {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP')) {
   $ipaddress = getenv('HTTP_CLIENT_IP');
  } else if (getenv('HTTP_X_FORWARDED_FOR')) {
   $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  } else if (getenv('HTTP_X_FORWARDED')) {
   $ipaddress = getenv('HTTP_X_FORWARDED');
  } else if (getenv('HTTP_FORWARDED_FOR')) {
   $ipaddress = getenv('HTTP_FORWARDED_FOR');
  } else if (getenv('HTTP_FORWARDED')) {
   $ipaddress = getenv('HTTP_FORWARDED');
  } else if (getenv('REMOTE_ADDR')) {
   $ipaddress = getenv('REMOTE_ADDR');
  } else {
   $ipaddress = 'UNKNOWN';
  }

  return $ipaddress;
 }

 // https://www.php.net/manual/en/function.com-create-guid.php
 public static function GUID()
 {
  return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
 }

 public static function checkMaxLength($string)
 {
   if( strlen($string) <= MAX_BYTE)
   {
      return True;
   }
   else 
   {
     return False;
   }
 }

 // https://stackoverflow.com/questions/381265/better-way-to-check-variable-for-null-or-empty-string
 public static function isNullOrEmptyString($str){
  return (!isset($str) || trim($str) === '');
 }

 public static function Exit($httpResponse)
 {
  $AccessControlAllowOrigin = "*";
  if(isset($_SERVER['HTTP_ORIGIN'])) {
    $AccessControlAllowOrigin = $_SERVER['HTTP_ORIGIN'];
  } 

   if(isset($httpResponse))
   {
     http_response_code($httpResponse->statusCode);
     header("Access-Control-Allow-Credentials: true");
     header("Access-Control-Allow-Origin: {$AccessControlAllowOrigin}");
     
     $message = json_encode($httpResponse, JSON_FORCE_OBJECT);
     exit($message);
   }
   exit(HttpCode::OK);
 }
}
