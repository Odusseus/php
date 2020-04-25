<?php namespace Items;

class HttpResponse
{

 public $code = 0,
 $message = "";

 public function __construct($code, $message)
 {
  $this->code = $code;
  $this->message = $message;
 }
}
