<?php namespace Items;

class HttpResponse
{

 public $statusCode = 0,
 $message = "";

 public function __construct($statusCod, $message)
 {
  $this->statusCode = $statusCode;
  $this->message = $message;
 }
}
