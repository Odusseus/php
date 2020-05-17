<?php

use Items\UserLoginEntity;

include '/Githup/Odusseus/php/items/elpida/source/UserLoginEntity.php';

class UserLoginEntityTest extends PHPUnit\Framework\TestCase
{

 /** @test */
 public function new_LoginEntity_Should_Create_A_Instance_Of_LoginEntity()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $cookie = "dummyCookie";

  // act
  $assert = new UserLoginEntity();
  $assert->appname = $appname;
  $assert->nickname = $nickname;
  $assert->cookie = $cookie;

  // assert
  $this->assertEquals($appname, $assert->appname);
  $this->assertEquals($nickname, $assert->nickname);
  $this->assertEquals($cookie, $assert->cookie);
 }

}
