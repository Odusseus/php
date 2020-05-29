<?php
use PHPUnit\Framework\TestCase;

include '/Githup/Odusseus/php/items/elpida/source/Environment.php';

class EnvironmentTest extends TestCase
{
 /**
  * @test
  * @dataProvider constantVariables
  *
  */
 public function define_Should_Return_Value($constant, $assert)
 {
  // arrange

  // act
  $result = $constant;

  //assert
  $this->assertEquals($assert, $result);
 }

 public function constantVariables()
 {
  return [
   [DEBUG, true],
   [DATA_DIR, "datatest"],
  ];
 }
}
