<?php
use Items\HttpResponse;

include '/Githup/Odusseus/php/items/elpida/source/HttpResponse.php';

class HttpResponseTest extends PHPUnit\Framework\TestCase
{
 /** @test */
 public function New_HttpResponse_Return_A_Instance_From_HttpResponse()
 {
  // arrange
  $code = 100;
  $message = "dummy message";

  // act
  $assert = new HttpResponse($code, $message);

  // assert
  $this->assertEquals($code, $assert->code);
  $this->assertEquals($message, $assert->message);
 }
}
