<?php namespace Items;

class HttpResponse
{

 public $statusCode = 0,
 $message = "",
 $disclaimer  = "";

 public function __construct($statusCode, $message)
 {
  $this->statusCode = $statusCode;
  $this->message = $message;
  $this->disclaimer = "Be careful! 1. This is a test API. All your data can be lost at any time. 2. The data is not encryte and not secure.";
 }
}
