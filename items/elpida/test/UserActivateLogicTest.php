<?php
use Items\HttpCode;
use Items\IpCheck;
use Items\User;
use Items\UserActivateLogic;

include '/Githup/Odusseus/php/items/elpida/source/UserActivateLogic.php';

class UserActivateLogicTest extends PHPUnit\Framework\TestCase
{

 protected function setUp(): void
 {
  $dataDir = DATA_DIR;

  foreach (glob("{$dataDir}/json/*") as $f) {
   unlink($f);
  };

  foreach (glob("{$dataDir}/mail/*") as $f) {
   unlink($f);
  }

  foreach (glob("{$dataDir}/txt/*") as $f) {
   unlink($f);
  }

  foreach (glob("{$dataDir}/value/*") as $f) {
   unlink($f);
  }
 }

/** @test */
 public function isIpCheck_Should_Return_HttpResponse_Intance_With_State_OK()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();

  // act
  $result = $userActivateLogic->isIpCheck();

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals("OK", $result->message);
 }

/** @test */
 public function isIpCheck_Should_Return_HttpResponse_Intance_With_State_FORBIDDEN()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $ipCheck = new IpCheck();
  $ipCheck->addBadIp();

  // act
  $result = $userActivateLogic->isIpCheck();

  // assert
  $this->assertEquals(HttpCode::FORBIDDEN, $result->code);
  $this->assertEquals("Forbidden, Ip is blacklisted.", $result->message);
 }

 /** @test */
 public function setIsAlive_Should_Return_HttpResponse_Intance_With_IsAlive_State()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();

  // act
  $result = $userActivateLogic->getIsAlive();

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals(STATE_TRUE, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_appname_Is_empty()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $appname = "";
  $value = APPNAME;
  $message = "$value is missing.";

  // act
  $result = $userActivateLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_NOT_FOUND_When_appname_Is_Not_Know()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $appname = "testAppname";
  $message = "{$appname} not found.";

  // act
  $result = $userActivateLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_OK_When_appname_Is_Found()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $appname = "test";
  $message = "OK";

  // act
  $result = $userActivateLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkNickname_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_nickname_Is_empty()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $nickname = "";
  $value = NICKNAME;
  $message = "$value is missing.";

  // act
  $result = $userActivateLogic->checkNickname($nickname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkNickname_Should_Return_HttpResponse_Intance_With_State_OK_When_Nickname_Is_full()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $nickname = "test";
  $message = "OK";

  // act
  $result = $userActivateLogic->checkNickname($nickname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function activeUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkAppname_Returns_Not_OK()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $appname = "";
  $nickname = "nicknameTest";
  $activationCode = "activationCodeTest";

  // act
  $result = $userActivateLogic->activeUser($appname, $nickname, $activationCode);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->code);
 }

/** @test */
 public function activeUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkAppname_checkNickname_Not_OK()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $appname = "appnameTest";
  $nickname = "";
  $activationCode = "activationCodeTest";

  // act
  $result = $userActivateLogic->activeUser($appname, $nickname, $activationCode);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->code);
 }

/** @test */
 public function activeUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkAppname_checkActivationCode_Not_OK()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $appname = "appnameTest";
  $nickname = "nicknameTest";
  $activationCode = "";

  // act
  $result = $userActivateLogic->activeUser($appname, $nickname, $activationCode);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->code);
 }

/** @test */
 public function activeUser_Should_Return_HttpResponse_Intance_With_State_NOT_FOUND_When_User_Is_Not_found()
 {
  // arrange
  $userActivateLogic = new UserActivateLogic();
  $appname = "test";
  $nickname = "nicknameTest";
  $activationCode = "activationCode";
  $message = "User is not found.";

  // act
  $result = $userActivateLogic->activeUser($appname, $nickname, $activationCode);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
public function activeUser_Should_Return_HttpResponse_Intance_With_State_OK_When_ActivationCode_Is_found()
{
 // arrange
 $userActivateLogic = new UserActivateLogic();
 $appname = "test";
 $nickname = "nicknameTest";
 $hashPassword = "hashPassword";
 $email = "email@mail.com";

 $user = User::set($appname, $nickname, $hashPassword, $email);

 $activationCode = $user->entity->activationCode;
 $message = "Account is activated.";

 // act
 $result = $userActivateLogic->activeUser($appname, $nickname, $activationCode);

 // assert
 $this->assertEquals(HttpCode::OK, $result->code);
 $this->assertEquals($message, $result->message);
}

/** @test */
public function activeUser_Should_Return_HttpResponse_Intance_With_State_NOT_FOUND_When_ActivationCode_Is_Not_found()
{
 // arrange
 $userActivateLogic = new UserActivateLogic();
 $appname = "test";
 $nickname = "nicknameTest";
 $hashPassword = "hashPassword";
 $email = "email@mail.com";

 $user = User::set($appname, $nickname, $hashPassword, $email);

 $activationCode = "dummyActivationCode";
 $value = ACTIVATION_CODE;
 $message = "{$value} not found.";

 // act
 $result = $userActivateLogic->activeUser($appname, $nickname, $activationCode);

 // assert
 $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
 $this->assertEquals($message, $result->message);
}

}
