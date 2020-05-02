<?php

use Items\UserEntity;

include '/Githup/Odusseus/php/items/elpida/source/UserEntity.php';

class UserEntityTest extends PHPUnit\Framework\TestCase
{

 /** @test */
 public function new_UserEntity_Should_Create_A_Instance_Of_UserEntity()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $hashPassword = "dummyHashPassword";
  $email = "dummyEmail";
  $activationCode = "dummyActivationCode";
  $state = "dummyState";
  $createdTimestamp = "dummyCreatedTimestamp";
  $id = "dummyId";

  // act
  $assert = new UserEntity();
  $assert->appname = $appname;
  $assert->nickname = $nickname;
  $assert->hashPassword = $hashPassword;
  $assert->email = $email;
  $assert->activationCode = $activationCode;
  $assert->state = $state;
  $assert->createdTimestamp = $createdTimestamp;
  $assert->id = $id;

  // assert
  $this->assertEquals($appname, $assert->appname);
  $this->assertEquals($nickname, $assert->nickname);
  $this->assertEquals($hashPassword, $assert->hashPassword);
  $this->assertEquals($email, $assert->email);
  $this->assertEquals($activationCode, $assert->activationCode);
  $this->assertEquals($state, $assert->state);
  $this->assertEquals($createdTimestamp, $assert->createdTimestamp);
  $this->assertEquals($id, $assert->id);
 }

}
