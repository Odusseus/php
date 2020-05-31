<?php
use Items\HttpCode;
use Items\IdMax;
use Items\IpCheck;
use Items\UserCreateLogic;

include '/Githup/Odusseus/php/items/elpida/source/UserCreateLogic.php';

class UserCreateLogicTest extends PHPUnit\Framework\TestCase
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
  $userCreateLogic = new UserCreateLogic();

  // act
  $result = $userCreateLogic->isIpCheck();

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals(SUCCESS, $result->message);
 }

/** @test */
 public function isIpCheck_Should_Return_HttpResponse_Intance_With_State_FORBIDDEN()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $ipCheck = new IpCheck();
  $ipCheck->addBadIp();

  // act
  $result = $userCreateLogic->isIpCheck();

  // assert
  $this->assertEquals(HttpCode::FORBIDDEN, $result->code);
  $this->assertEquals("Forbidden, Ip is blacklisted.", $result->message);
 }

 /** @test */
 public function setIsAlive_Should_Return_HttpResponse_Intance_With_IsAlive_State()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();

  // act
  $result = $userCreateLogic->getIsAlive();

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals(STATE_TRUE, $result->message);
 }

 /** @test */
 public function isIdMaxCheck_Should_Return_HttpResponse_Intance_With_State_OK_When_IdMax_Is_Less_Than_MAX_CREATEUSER()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();

  // act
  $result = $userCreateLogic->isIdMaxCheck();

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals(STATE_TRUE, $result->message);
 }

/** @test */
 public function isIdMaxCheck_Should_Return_HttpResponse_Intance_With_State__When_IdMax_Is_Greater_Than_MAX_CREATEUSER()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $message = "Maximum users is reached.";
  $userIdMax = new IdMax(MAX_CREATEUSER);

  for ($x = 0; $x <= 100; $x++) {
   $userIdMax->next();
  }

  // act
  $result = $userCreateLogic->isIdMaxCheck();

  // assert
  $this->assertEquals(HttpCode::LOCKED, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_appname_Is_empty()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $appname = "";
  $value = APPNAME;
  $message = "$value is missing.";

  // act
  $result = $userCreateLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_NOT_FOUND_When_appname_Is_Not_Know()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $appname = "testAppname";
  $message = "{$appname} not found.";

  // act
  $result = $userCreateLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_OK_When_appname_Is_Found()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $appname = "test";
  $message = SUCCESS;

  // act
  $result = $userCreateLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function checkNickname_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_nickname_Is_empty()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $nickname = "";
  $value = NICKNAME;
  $message = "$value is missing.";

  // act
  $result = $userCreateLogic->checkNickname($nickname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkNickname_Should_Return_HttpResponse_Intance_With_State_OK_When_Nickname_Is_full()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $nickname = "test";
  $message = SUCCESS;

  // act
  $result = $userCreateLogic->checkNickname($nickname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkPassword_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_Password_Is_empty()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $nickname = "";
  $value = PASSWORD;
  $message = "$value is missing.";

  // act
  $result = $userCreateLogic->checkPassword($nickname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkPassword_Should_Return_HttpResponse_Intance_With_State_OK_When_Password_Is_full()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $nickname = "test";
  $message = SUCCESS;

  // act
  $result = $userCreateLogic->checkPassword($nickname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkEmail_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_Email_Is_empty()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $nickname = "";
  $value = EMAIL;
  $message = "$value is missing.";

  // act
  $result = $userCreateLogic->checkEmail($nickname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkEmail_Should_Return_HttpResponse_Intance_With_State_OK_When_Email_Is_full()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $nickname = "test";
  $message = SUCCESS;

  // act
  $result = $userCreateLogic->checkEmail($nickname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function createUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkAppname_Returns_Not_OK()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $content = '{
    "appname": "",
    "nickname": "pascal2",
    "password": "Sensas",
    "email": "testemail@test.org"
  }';

  // act
  $result = $userCreateLogic->createUser($content);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->code);
 }

/** @test */
 public function createUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkNickname_Returns_Not_OK()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $content = '{
   "appname": "test",
   "nickname": "",
   "password": "Sensas",
   "email": "testemail@test.org"
 }';

  // act
  $result = $userCreateLogic->createUser($content);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->code);
 }

/** @test */
 public function createUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkPassword_Returns_Not_OK()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $content = '{
   "appname": "test",
   "nickname": "nickname",
   "password": "",
   "email": "testemail@test.org"
 }';

  // act
  $result = $userCreateLogic->createUser($content);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->code);
 }

/** @test */
 public function createUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_CheckEmail_Returns_Not_OK()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $content = '{
   "appname": "test",
   "nickname": "nickname",
   "password": "password",
   "email": ""
 }';

  // act
  $result = $userCreateLogic->createUser($content);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->code);
 }

/** @test */
 public function createUser_Should_Return_HttpResponse_Intance_With_State_OK_When_User_Is_Create()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $content = '{
   "appname": "test",
   "nickname": "nickname",
   "password": "password",
   "email": "testemail@mail.org"
 }';

  // act
  $result = $userCreateLogic->createUser($content);

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
 }

}
