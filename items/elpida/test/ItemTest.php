<?php
use Items\Item;

include '/Githup/Odusseus/php/items/elpida/source/Item.php'; // must include if tests are for non OOP code

class ItemTest extends PHPUnit\Framework\TestCase
{

  protected  function setUp(): void
  {
    $dataDir =  DATA_DIR;
    $valuedir = VALUE_DIR; 

    foreach(glob("{$dataDir}/{$valuedir}/*") as $file) {
      unlink($file);
    };
  }

 /** @test */
 public function set_Item_Should_Create_A_Instance_Of_The_Item()
 {
  // arrange
  $key = "Test";
  $value = 42;

  // act
  $assert = Item::set($key, $value);

  // assert
  $this->assertEquals($assert->key, $key);
  $this->assertEquals($assert->value, $value);
 }

 /** @test */
 public function delete_Item_Should_Delete_The_Item_File()
 {
  // arrange
  $key = "Test";
  $value = 42;
  $item = Item::set($key, $value);

  // act
  $item->delete();
  $assert = file_exists($item->getFilename());

  // assert
  $x = $item->getFilename();
  $this->assertFalse($assert);
  $this->assertNull($item->key);
  $this->assertNull($item->value);
 }

 /** @test */
 public function get_Item_Should_Return_A_Item()
 {
  // arrange
  $key = "Test";
  $value = 42;
  $item = Item::set($key, $value);

  // act
  $assert = Item::get($key);

  // assert
  $this->assertEquals($assert->key, $key);
  $this->assertEquals($assert->value, $value);
 }

 /** @test */
 public function getFilename_Should_Return_The_Filename()
 {
  // arrange
  $key = "test";
  $value = 42;
  $item = Item::set($key, $value);

  // act
  $assert = $item->getFilename();

  // assert
  $this->assertEquals($assert, "datatest/value/test.bin");
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
  $value = 42;
  $assert = Item::set($key, $value);
  $assert->$value = null;

  // act
  $assert->load();

  // assert
  $this->assertEquals($assert->value, $value);
 }
}
