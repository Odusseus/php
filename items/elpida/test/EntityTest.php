<?php
use Elpida\Entity;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/Entity.php'); // must include if tests are for non OOP code

class EntityTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function new_Entity_Shoul_A_Instance_Of_Entity()
  {
    // arrange  
    $timestamp = date("d-m-Y H:i:s");
    $key = "ketsKey";
    
    // act
    $assert = new Entity($key);

    // assert
    $this->assertEquals($assert->id, 0);
    $this->assertEquals($assert->key, $key);    
    $this->assertEqualsWithDelta($assert->timestamp, $timestamp, 1);
  }

  /** @test */
  public function set_Entity_Shoul_Set_The_Instance_Variables()
  {
    // arrange  
    $key = "ketsKey";
    $assert = new Entity($key);
    $id = 100;
    $key = "127.0.0.2";
    $timestamp = date("d-m-Y H:i:s");
    $data = (object)["id" => $id,"key" => $key,"timestamp" => $timestamp];
    
    // act
    $assert->set( $data);

    // assert
    $this->assertEquals($assert->id, $id);
    $this->assertEquals($assert->key, $key);    
    $this->assertEquals($assert->timestamp, $timestamp);
  }
}
?>
