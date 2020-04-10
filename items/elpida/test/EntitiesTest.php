<?php
use Elpida\Entities;
use Elpida\Entity;

include('/Githup/Odusseus/php/items/elpida/source/Entities.php');

class EntitiesTest extends PHPUnit\Framework\TestCase
{

  protected  function setUp(): void
  {
    $dataDir =  DATA_DIR;

    foreach(glob("{$dataDir}/json/*") as $f) {
      unlink($f);
    };
  }

  /** @test */
  public function Entities_Return_A_Instantie()
  {
    // arrange  
    $entityname = "Capital";
    
    // act
    $assert = new Entities($entityname);

    // assert
    $this->assertEquals($assert->entityname, $entityname);
    $this->assertEquals($assert->filename, "datatest/json/Capital.json");
  }


   /** @test */
   public function add_Add_A_Item_To_The_Entities()
   {
     // arrange  
     $entityname = "Capital";
     $entities = new Entities($entityname);
     $value0 = "London";
     $value1 = "Paris";
     $entity0 = new Entity($value0);
     $entity1 = new Entity($value1);
     $entities->add($entity0);
     $entities->add($entity1);

     // act
     $assert = new Entities($entityname);
 
     // assert
     $this->assertEquals($assert->list[0]->key, $value0);
     $this->assertEquals($assert->list[1]->key, $value1);
   }

   /** @test */
   public function delete_The_Entity_File()
   {
     // arrange  
     $entityname = "Capital";
     $entities = new Entities($entityname);
     $value0 = "London";
     $entity0 = new Entity($value0);
     $entities->add($entity0);
     $filename = $entities->filename;
     
     // act
     $entities->delete();
     $assert = file_exists($filename);
 
     // assert
     $this->assertFalse($assert);
   }

   /** @test */
   public function save_The_Entity_File()
   {
     // arrange  
     $entityname = "Capital";
     $entities = new Entities($entityname);  
     $filename = $entities->filename;

     if(file_exists($filename))
     {
      unlink($filename);
     }  

     // act
     $entities->save();
     $assert = file_exists($filename);
 
     // assert
     $this->assertTrue($assert);
   }

}


?>