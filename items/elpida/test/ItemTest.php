<?php
use Items\Item;

include '/Githup/Odusseus/php/items/elpida/source/Item.php'; // must include if tests are for non OOP code

class ItemTest extends PHPUnit\Framework\TestCase
{

 protected function setUp(): void
 {
  $dataDir = DATA_DIR;
  $valueDir = VALUE_DIR;

  foreach (glob("{$dataDir}/{$valueDir}/*") as $file) {
   unlink($file);
  };
 }

 /** @test */
 public function set_Item_Should_Create_A_Instance_Of_The_Item()
 {
  // arrange
  $key = "Test";
  $value = "TestValue";
  $version = 42;

  // act
  $assert = Item::set($key, $value, $version);

  // assert
  $this->assertEquals($key, $assert->key);
  $this->assertEquals($value, $assert->itemEntity->value);
  $this->assertEquals($version, $assert->itemEntity->version);
 }

 /** @test */
 public function delete_Item_Should_Delete_The_Item_File()
 {
  // arrange
  $key = "Test";
  $value = "TestValue";
  $version = 42;

  $item = Item::set($key, $value, $version);

  // act
  $item->delete();
  $assert = file_exists($item->getFilename());

  // assert
  $result = $item->getFilename();

  $this->assertFalse($assert);
  $this->assertNull($item->key);
  $this->assertNull($item->itemEntity);
 }

 /** @test */
 public function get_Item_Should_Return_A_Item()
 {
  // arrange
  $key = "Test";
  $value = "TestValue";
  $version = 42;

  $item = Item::set($key, $value, $version);

  // act
  $assert = Item::get($key);

  // assert
  $this->assertEquals($key, $assert->key);
  $this->assertEquals($value, $assert->itemEntity->value);
  $this->assertEquals($version, $assert->itemEntity->version);
 }

 /** @test */
 public function getFilename_Should_Return_The_Filename()
 {
  // arrange
  $key = "test";
    $value = "TestValue";
  $version = 42;
  
  $item = Item::set($key, $value, $version);

  // act
  $assert = $item->getFilename();

  // assert
  $this->assertEquals($assert, "sb/datatest/value/test.json");
 }

 /** @test */
 public function save_Should_Save_The_Item_To_A_File()
 {
  // arrange
  $key = "test";
  $value = 42;
  $item = new Item();
  $item->key = $key;
  $item->value = $value;

  // act
  $item->save();
  $assert = file_exists($item->getFilename());
  // assert
  $this->assertTrue($assert);
 }

 /** @test */
 public function save_Should_Not_Save_A_Item_With_A_Empty_Key()
 {
  // arrange
  $key = "";
  $value = 42;
  $item = new Item();
  $item->key = $key;
  $item->value = $value;

  // act
  $item->save();
  $assert = file_exists($item->getFilename());

  // assert
  $this->assertFalse($assert);
 }

 /** @test */
 public function load_Should_Load_A_Item()
 {
  // arrange
  $key = "test";
  $value = "TestValue";
  $version = 42;
  $assert = Item::set($key, $value, $version);
  $assert->$value = null;

  // act
  $assert->load();

  // assert
  $this->assertEquals($value, $assert->itemEntity->value);
 }

 /** @test */
 public function isSet_Should_Return_True_When_value_IsSet()
 {
  // arrange
  $key = "test";
  $value = "TestValue";
  $version = 42;
  $assert = Item::set($key, $value, $version);
  
  // act
  $result = $assert->isSet();

  // assert
  $this->assertTrue($result);
 }

 /** @test */
 public function isSet_Should_Return_False_When_value_Is_Not_Set()
 {
  // arrange
  $assert = new Item();
  
  // act
  $result = $assert->isSet();

  // assert
  $this->assertFalse($result);
 }
}
