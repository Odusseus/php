<?php
use Elpida\Common;

include('/Githup/Odusseus/php/items/elpida/source/Common.php'); // must include if tests are for non OOP code

class CommonTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function getJsonValue_Shoul_Return_The_Value_Associated_To_Valuename_When_Found()  {
    // arrange  
    $json = <<<EOT
    {
      "appname": "test",
      "nickname": "Dummy",
      "password": "Sensas",
      "email": "dummy@live.nl"
    }
    EOT;

    $decoded = json_decode($json, true);
    $assert = "Dummy";
    $valueName = "nickname";

    // act
    $result = Common::getJsonValue($decoded, $valueName);

    // assert
    $this->assertEquals($result, $assert);
  }

   /** @test */
   public function getJsonValue_Shoul_Return_Null_When_Not_Found_The_Key()  {
    // arrange  
    $json = <<<EOT
    {
      "appname": "test",
      "nickname": "Dummy",
      "password": "Sensas",
      "email": "dummy@live.nl"
    }
    EOT;

    $decoded = json_decode($json, true);
    $valueName = "xxx";

    // act
    $result = Common::getJsonValue($decoded, $valueName);

    // assert
    $this->assertNull($result);
    
  }
}

?>
