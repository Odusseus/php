<?php namespace Items;

class HttpResponse
{

 public $statusCode = 0,
 $message = "",
 $token = "",
 $tokenTimeout = "",
 $disclaimer  = "";

 public function __construct()
 {
  $this->disclaimer = "Be careful! 1. This is a test API. All your data can be lost at any time. 2. The data is not encryte and not secure.";
 }

 public static function builder($statusCode, $message)
 {
  $instance = new self();
  $instance->buildHttpResponse($statusCode, $message, null, null);
  return $instance;
}

public static function builderWithToken($statusCode, $message, $token, $tokenTimeout)
{
  $instance = new self();
  $instance->buildHttpResponse($statusCode, $message, $token, $tokenTimeout);
  return $instance;
 }

 protected function buildHttpResponse($statusCode, $message, $token, $tokenTimeout)
 {
  $this->statusCode = $statusCode;
  $this->message = $message;
  $this->token = $token;
  $this->tokenTimeout = $tokenTimeout;
 }
}
