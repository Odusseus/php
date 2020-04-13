<?php
use Elpida\Item;

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
}
