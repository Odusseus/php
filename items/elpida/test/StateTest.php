<?php
use Items\State;
use PHPUnit\Framework\TestCase;

include '/Githup/Odusseus/php/items/elpida/source/enum/State.php';

class StateTest extends TestCase
{
 /**
  * @test
  * @dataProvider stateVariables
  *
  */
 public function state_Should_Return_Value($statusCode, $assert)
 {
 // arrange

 // act
 $result = constant("Items\State::$statusCode");


  //assert
  $this->assertEquals($result, $assert);
 }

 public function stateVariables()
 {
  return [
   ["Newcomer", 0],
   ["Active", 1],
   ["Blocked", 2]
  ];
 }
}
