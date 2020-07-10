<?php
use Items\HttpCode;
use Items\IpCheck;
use Items\UserLoginLogic;
use Items\UserCreateLogic;
use Items\UserActivateLogic;
use Items\User;

include '/Githup/Odusseus/php/items/elpida/source/UserLoginLogic.php';
include '/Githup/Odusseus/php/items/elpida/source/UserCreateLogic.php';
include '/Githup/Odusseus/php/items/elpida/source/UserActivateLogic.php';

class UserLoginLogicTest extends PHPUnit\Framework\TestCase
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
  $userLoginLogic = new UserLoginLogic();

  // act
  $result = $userLoginLogic->isIpCheck();

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals(SUCCESS, $result->message);
 }

/** @test */
 public function isIpCheck_Should_Return_HttpResponse_Intance_With_State_FORBIDDEN()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $ipCheck = new IpCheck();
  $ipCheck->addBadIp();

  // act
  $result = $userLoginLogic->isIpCheck();

  // assert
  $this->assertEquals(HttpCode::FORBIDDEN, $result->statusCode);
  $this->assertEquals("Forbidden, Ip is blacklisted.", $result->message);
 }

 /** @test */
 public function setIsAlive_Should_Return_HttpResponse_Intance_With_IsAlive_State()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();

  // act
  $result = $userLoginLogic->getIsAlive();

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals(STATE_TRUE, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_appname_Is_empty()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $appname = "";
  $value = APPNAME;
  $message = "$value is missing.";

  // act
  $result = $userLoginLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_NOT_FOUND_When_appname_Is_Not_Know()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $appname = "testAppname";
  $message = "{$appname} not found.";

  // act
  $result = $userLoginLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkAppname_Should_Return_HttpResponse_Intance_With_State_OK_When_appname_Is_Found()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $appname = "test";
  $message = SUCCESS;

  // act
  $result = $userLoginLogic->checkAppname($appname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function checkNickname_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_nickname_Is_empty()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $nickname = "";
  $value = NICKNAME;
  $message = "$value is missing.";

  // act
  $result = $userLoginLogic->checkNickname($nickname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkNickname_Should_Return_HttpResponse_Intance_With_State_OK_When_Nickname_Is_full()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $nickname = "test";
  $message = SUCCESS;

  // act
  $result = $userLoginLogic->checkNickname($nickname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkPassword_Should_Return_HttpResponse_Intance_With_State_UNPROCESSABLE_ENTITY_When_Password_Is_empty()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $nickname = "";
  $value = PASSWORD;
  $message = "$value is missing.";

  // act
  $result = $userLoginLogic->checkPassword($nickname);

  // assert
  $this->assertEquals(HttpCode::UNPROCESSABLE_ENTITY, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function checkPassword_Should_Return_HttpResponse_Intance_With_State_OK_When_Password_Is_full()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $nickname = "test";
  $message = SUCCESS;

  // act
  $result = $userLoginLogic->checkPassword($nickname);

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function loginUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkAppname_Returns_Not_OK()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $content = '{
    "appname": "",
    "nickname": "pascal2",
    "password": "Sensas"
  }';

  // act
  $result = $userLoginLogic->loginUser($content);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->statusCode);
 }

/** @test */
 public function loginUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkNickname_Returns_Not_OK()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $content = '{
   "appname": "test",
   "nickname": "",
   "password": "Sensas"
 }';

  // act
  $result = $userLoginLogic->loginUser($content);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->statusCode);
 }

/** @test */
 public function loginUser_Should_Return_HttpResponse_Intance_With_State_Not_OK_When_checkPassword_Returns_Not_OK()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  $content = '{
   "appname": "test",
   "nickname": "nickname",
   "password": ""
 }';

  // act
  $result = $userLoginLogic->loginUser($content);

  // assert
  $this->assertNotEquals(HttpCode::OK, $result->statusCode);
 }

 /** @test */
 public function loginUser_Should_Return_HttpResponse_Intance_With_State_OK_When_User_Is_Login()
 {
  // arrange
  $userCreateLogic = new UserCreateLogic();
  $content = '{
   "appname": "test",
   "nickname": "nickname",
   "password": "password",
   "email": "testemail@mail.org"
 }';
 $userCreateLogic->createUser($content); 

 $userActivateLogic = new UserActivateLogic();
 $appname = "test";
 $nickname = "nicknameTest";
 $hashPassword = password_hash("password", PASSWORD_DEFAULT);
 $email = "email@mail.com";
 $user = User::set($appname, $nickname, $hashPassword, $email);
 $activationCode = $user->entity->activationCode;
 $userActivateLogic->activeUser($appname, $nickname, $activationCode);

 $userLoginLogic = new UserLoginLogic();
  // Cannot modify header information - headers already sent by (output started at phar://C:/phpunit/phpunit-9.0.1.phar/phpunit/Util/Printer.php:64)
  $userLoginLogic->test = true;

  // act
  $result = $userLoginLogic->loginUser($content);

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
 }

 /** @test */
 public function loginUser_Should_Return_HttpResponse_Not_Found_When_Combination_Appname_Nickname_Is_Not_Found()
 {
  // arrange
  $userLoginLogic = new UserLoginLogic();
  // Cannot modify header information - headers already sent by (output started at phar://C:/phpunit/phpunit-9.0.1.phar/phpunit/Util/Printer.php:64)
  $userLoginLogic->test = true;

  $content = '{
   "appname": "test",
   "nickname": "nickname",
   "password": "password"
 }';

  // act
  $result = $userLoginLogic->loginUser($content);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->statusCode);
 }

}
