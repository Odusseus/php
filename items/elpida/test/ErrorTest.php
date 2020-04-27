<?php
use Items\Error;
use PHPUnit\Framework\TestCase;

include '/Githup/Odusseus/php/items/elpida/source/enum/Error.php';

class ErrorTest extends TestCase
{
 /**
  * @test
  * @dataProvider errorVariables
  *
  */
 public function Error_Should_Return_Value($code, $assert)
 {
 // arrange

 // act
 $result = constant("Items\Error::$code");


  //assert
  $this->assertEquals($assert, $result);
 }

 public function errorVariables()
 {
  return [
   ["FileNotFound", "Error 1 : File not found."],
   ["BadIP", "Error 2 : BadIp."],
   ["EmptyValue", "Error 3 : Null or empty value."]
  ];
 }
}
