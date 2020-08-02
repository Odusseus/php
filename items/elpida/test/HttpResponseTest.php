<?php
use Items\HttpResponse;

include '/Githup/Odusseus/php/items/elpida/source/HttpResponse.php';

class HttpResponseTest extends PHPUnit\Framework\TestCase
{
 /** @test */
 public function New_HttpResponse_Return_A_Instance_From_HttpResponse()
 {
  // arrange
  $statusCode = 100;
  $message = "dummy message";

  // act
  $assert = HttpResponse::builder($statusCode, $message);

  // assert
  $this->assertEquals($statusCode, $assert->statusCode);
  $this->assertEquals($message, $assert->message);
 }
}
