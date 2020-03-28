<?php
use Elpida\Common;

include('/Githup/Odusseus/php/items/elpida/source/Common.php'); // must include if tests are for non OOP code

class CommonTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function getJsonValue_Shoul_Return_The_Value_Associated_To_Valuename_When_Found()  {
    // arrange  
    $decoded = `[
      {
         "Naam":"JSON",
         "Type":"Gegevensuitwisselingsformaat",
         "isProgrammeertaal":false,
         "Zie ook":[
            "XML",
            "ASN.1"
         ]`;
    $assert = "Naam";
    $valueName = "JSON";

    // act
    $result = Common::getJsonValue($decoded, $valueName);

    // assert
    $this->assertEquals($result, $assert);
  }
}

?>
