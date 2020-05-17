<?php

use Items\ItemEntity;

include '/Githup/Odusseus/php/items/elpida/source/ItemEntity.php';

class ItemEntityTest extends PHPUnit\Framework\TestCase
{

 /** @test */
 public function new_ItemEntity_Should_Create_A_Instance_Of_ItemEntity()
 {
  // arrange
  $value = "dummyValue";
  $version = 42;

  // act
  $assert = new ItemEntity($value, $version);

  // assert
  $this->assertEquals($value, $assert->value);
  $this->assertEquals($version, $assert->version);
 }

}
