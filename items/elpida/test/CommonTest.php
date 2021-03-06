<?php
use Items\Common;
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
  public function getClientIp_return_UNKNOWN_When_No_environment_Is_Set()
  {
    // arrange
    $assert = 'UNKNOWN';

    // act
    $result = Common::getClientIp();

    //assert
    $this->assertEquals($result, $assert);
  }

  /** @test */
  public function getClientIp_return_UNKNOWN_When_Environment_Variable_Is_Not_found()
  {
    // arrange
    putenv('HTTP_CLIENT_IP');
    putenv('HTTP_X_FORWARDED_FOR');
    putenv('HTTP_X_FORWARDED');
    putenv('HTTP_FORWARDED_FOR');
    putenv('HTTP_FORWARDED');
    putenv('REMOTE_ADDR');

    putenv("DummyParameter=123");
    $assert = 'UNKNOWN';

    // act
    $result = Common::getClientIp();

    //assert
    $this->assertEquals($result, $assert);
  }

  /**
   * @test
   * @dataProvider environmentVariables
   * 
   */
  public function getClientIp_return_the_assert_When_Environment_The_Variable_Is_Found($env, $assert)
  {
    // arrange
    putenv('DummyParameter');
    putenv('HTTP_CLIENT_IP');
    putenv('HTTP_X_FORWARDED_FOR');
    putenv('HTTP_X_FORWARDED');
    putenv('HTTP_FORWARDED_FOR');
    putenv('HTTP_FORWARDED');
    putenv('REMOTE_ADDR');

    putenv("{$env}={$assert}");

    // act
    $result = Common::getClientIp();

    //assert
    $this->assertEquals($result, $assert);
  }

  public function environmentVariables()
  {
    return [
      ['HTTP_CLIENT_IP', 1],
      ['HTTP_X_FORWARDED_FOR', 2],
      ['HTTP_X_FORWARDED', 3],
      ['HTTP_FORWARDED_FOR', 4],
      ['HTTP_FORWARDED', 5],
      ['REMOTE_ADDR', 6]
    ];
  }

   /** @test */
   public function GUID_Should_Return_A_GUID()
   {
     // arrange
 
     // act
     $result = Common::GUID();
 
     //assert
     $this->assertNotNull($result);
     $this->assertEquals(36, strlen($result));
   }
   
   /**
   * @test
   * @dataProvider stringVariables
   * 
   */
  public function checkMaxLength_Should_Return_If_The_String_Length_Ecceeds_The_Max_Length($string, $assert)
  {
    // arrange

    // act
    $result = Common::checkMaxLength($string);

    //assert
    $this->assertEquals($result, $assert);
  }

  public function stringVariables()
  {
    $maxString = str_repeat("X", 100001);

    return [
      ['', True],
      ['0123456789', True],
      [$maxString, False]
    ];
  }

 /**
   * @test
   * @dataProvider isNullOrEmptyStringVariables
   * 
   */
  public function isNullOrEmptyString_Should_Return_False_When_String_Is_Set($string, $assert)
  {
    // arrange

    // act
    $result = Common::isNullOrEmptyString($string);

    //assert
    $this->assertEquals($assert, $result);
  }

  public function isNullOrEmptyStringVariables()
  {
    return [
      ['', True],
      ['0123456789', False],
      [NULL, True]
    ];
  }
}
