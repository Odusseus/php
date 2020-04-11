<?php
use Elpida\Id;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/Id.php'); // must include if tests are for non OOP code

class IdTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function new_Id_Should_Create_A_Instance_Of_Entity()
  {
    // arrange  
    $timestamp = date("d-m-Y H:i:s");
    $key = "ketsKey";
    
    // act
    $assert = new Id($key);

    // assert
    $this->assertEquals($assert->id, 1);
    $this->assertEquals($assert->key, $key);    
    $this->assertEqualsWithDelta($assert->timestamp, $timestamp, 1);
  }  
}
?>
