<?php
use Elpida\IdMax;

include('/Githup/Odusseus/php/items/elpida/source/IdMax.php'); // must include if tests are for non OOP code

class IdMaxTest extends PHPUnit\Framework\TestCase
{
  protected  function setUp(): void
  {
    $path = DATA_DIR."/".TXT_DIR."/*"; 
    foreach(glob($path) as $f) {
      unlink($f);
    };
  }

  /** @test */
  public function new_IdMax_Should_Create_A_Instance_Of_IdMax()
  {
    // arrange
    $idName = "test";
    
    // act
    $assert = new IdMax($idName);

    // assert
    $this->assertEquals($assert->get(), 0);
  }  

  /** @test */
  public function delete_IdMax_Should_Delete_The_MaxID_File()
  {
    // arrange
    $idName = "test";
    $idMax = new IdMax($idName);
    
    // act
    $idMax->delete();
    $assert = file_exists($idMax->filename);

    // assert
    $this->assertFalse($assert);
  }

  /** @test */
  public function next_IdMax_Should_Increment_The_IdMax()
  {
    // arrange
    $idName = "test";
    $idMax = new IdMax($idName);
    
    // act
    $idMax->next();
    $idMax->next();
    $idMax->next();
    $assert = new IdMax($idName);

    // assert
    $this->assertEquals($assert->get(), 3);
  }  

  /** @test */
  public function set_IdMax_Should_Set_A_Value()
  {
    // arrange
    $idName = "test";
    $idMax = new IdMax($idName);
    $maxValue = 42;
    
    // act
    $idMax->set($maxValue);
    $assert = new IdMax($idName);

    // assert
    $this->assertEquals($assert->get(), $maxValue);
  }  
}
?>
