<?php
use Elpida\Ids;
use Elpida\Id;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/Ids.php'); // must include if tests are for non OOP code

class IdsTest extends PHPUnit\Framework\TestCase
{

  protected  function setUp(): void
  {
    Ids::delete();
  }

  /** @test */
  public function new_Ids_Should_Create_A_Instance_Of_Ids()
  {
    // arrange  

    // act
    $assert1 = Ids::new();
    $assert2 = Ids::new();

    // assert
    $this->assertEquals($assert1, $assert2);
  }
  
  /** @test */
  public function delete_Should_Delete_The_File()
  {
    // arrange  

    // act
    Ids::delete();

    // assert
    $this->assertFalse(Ids::isSet());
    $this->assertFalse(file_exists(Ids::$filename));
  }

/** @test */
public function save_Should_Save_The_Ids()
{
  // arrange  
  Ids::delete();
  $ids = Ids::new();

  // act
  $ids->save();

  // assert
  $this->assertTrue(file_exists(Ids::$filename));
}

  /** @test */
  public function add_Should_Add_Items_To_Ids()
  {
    // arrange  
    Ids::delete();
    $ids = Ids::new();
    $id1 = new Id("ABC");
    $id2 = new Id("DEF");

    // act
    $ids->add($id1);
    $ids->add($id2);

    // assert
    $this->assertEquals(count($ids->list), 2);
    $this->assertTrue(file_exists(Ids::$filename));
  }

   /** @test */
   public function getId_Should_Return_Item_Corresponding_To_The_Key()
   {
     // arrange  
     Ids::delete();
     $ids = Ids::new();
     $id1 = new Id("ABC");
     $id2 = new Id("DEF");
     $ids->add($id1);
     $ids->add($id2);
 
     // act
     $assert = $ids->getId($id2->key);
     // assert
     $this->assertEquals($assert->id, $id2->id);
     $this->assertEquals($assert->key, $id2->key);
   }

   /** @test */
   public function getList_Should_Return_The_List_Of_Items()
   {
     // arrange  
     Ids::delete();
     $ids = Ids::new();
     $id1 = new Id("ABC");
     $ids->add($id1);
     $id2 = new Id("DEF");
     $ids->add($id2);
   
   
     // act
     $list = $ids->getList();

     // assert
     $this->assertEquals(count($list), 2);
   }

   /** @test */
   public function next_Should_Add_One_To_The_Id_from_A_Key()
   {
     // arrange  
     Ids::delete();
     $ids = Ids::new();
     $id1 = new Id("ABC");
     $ids->add($id1);
   
     // act
     $id = $ids->next($id1->key);
     // assert
     $this->assertEquals($id, 2);
   }
}
?>
