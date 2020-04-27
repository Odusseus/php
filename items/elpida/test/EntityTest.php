<?php
use Items\Entity;

date_default_timezone_set('Europe/Amsterdam');

include '/Githup/Odusseus/php/items/elpida/source/Entity.php'; // must include if tests are for non OOP code

class EntityTest extends PHPUnit\Framework\TestCase
{

 /** @test */
 public function new_Entity_Should_Create_A_Instance_Of_Entity()
 {
  // arrange
  $timestamp = date("d-m-Y H:i:s");
  $key = "ketsKey";

  // act
  $assert = new Entity($key);

  // assert
  $this->assertEquals(0, $assert->id);
  $this->assertEquals($key, $assert->key);
  $this->assertEqualsWithDelta($timestamp, $assert->timestamp, 1);
 }

 /** @test */
 public function set_Entity_Should_Set_The_Instance_Variables()
 {
  // arrange
  $key = "ketsKey";
  $assert = new Entity($key);
  $id = 100;
  $key = "127.0.0.2";
  $timestamp = date("d-m-Y H:i:s");
  $data = (object) ["id" => $id, "key" => $key, "timestamp" => $timestamp];

  // act
  $assert->set($data);

  // assert
  $this->assertEquals($id, $assert->id);
  $this->assertEquals($key, $assert->key);
  $this->assertEquals($timestamp, $assert->timestamp);
 }
}
