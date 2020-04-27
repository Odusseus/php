<?php
use Items\Constant;
use PHPUnit\Framework\TestCase;

include '/Githup/Odusseus/php/items/elpida/source/Constant.php';

class ConstantTest extends TestCase
{
  /**
   * @test
   * @dataProvider constantVariables
   * 
   */
  public function define_Should_Return_Value($constant, $assert)
  {
    // arrange

    // act
    $result = $constant;

    //assert
    $this->assertEquals($assert, $result);
  }

  public function constantVariables()
  {
    return [
      [ACTIVATION_CODE, "activationcode"],
      [APPNAME, "appname"],
      [COOKIE, "items"],
      [EMAIL, "email"],
      [ID, "id"],
      [BADIP, "badip"],      
      [ISALIVE, "isalive"],
      [ITEMLENGTH, "itemlength"],
      [JSON_DIR, "json"],
      [MAIL_DIR, "mail"],
      [MAX_BYTE, 10000],
      [MAX_CREATEUSER, "createuser"],
      [MAX_LENGTH, "maxlength"],
      [NICKNAME, "nickname"],
      [PASSWORD, "password"],
      [STATE_TRUE, "true"],
      [STATE_FALSE, "false"],
      [USER_DIR, "user"],
      [VALUE, "value"],
      [VALUE_DIR, "value"],
      [TXT_DIR, "txt"]
    ];
  }
}
?>