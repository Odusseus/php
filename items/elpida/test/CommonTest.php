<?php
use Elpida\Common;
use PHPUnit\Framework\TestCase;

include '/Githup/Odusseus/php/items/elpida/source/Common.php'; // must include if tests are for non OOP code

class CommonTest extends TestCase
{

   
  /** @test */
  public function getJsonValue_Shoul_Return_The_Value_Associated_To_Valuename_When_Found()
  {
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
  public function getJsonValue_Shoul_Return_Null_When_Not_Found_The_Key()
  {
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

  /** @test */
  public function get_client_ip_return_UNKNOWN_When_No_environment_Is_Set()
  {
    // arrange
    $assert = 'UNKNOWN';

    // act
    $result = Common::get_client_ip();

    //assert
    $this->assertEquals($result, $assert);
  }

  /** @test */
  public function get_client_ip_return_UNKNOWN_When_Environment_Variable_Is_Not_found()
  {
    // arrange
    putenv("DummyParameter");
    $assert = 'UNKNOWN';

    // act
    $result = Common::get_client_ip();

    //assert
    $this->assertEquals($result, $assert);
  }

  // /** 
  //  * @dataProvider additionProviderX 
  //  */
  // public function get_client_ip_return_the_assert_When_Environment_The_Variable_Is_Found($env, $assert)
  // {
  //   // arrange
  //   putenv("{$env}={$assert}");

  //   // act
  //   $result = Common::get_client_ip();

  //   //assert
  //   $this->assertEquals($result, $assert);
  // }

  // public function additionProviderX()
  // {
  //   return [
  //     ['HTTP_CLIENT_IP', 1],
  //     ['HTTP_X_FORWARDED_FOR', 2],
  //     ['HTTP_X_FORWARDED', 3],
  //     ['HTTP_FORWARDED_FOR', 4],
  //     ['HTTP_FORWARDED', 5],
  //     ['REMOTE_ADDR', 6]
  //   ];
  // }
}
?>