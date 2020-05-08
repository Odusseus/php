<?php
use Items\State;
use Items\User;

include '/Githup/Odusseus/php/items/elpida/source/User.php'; // must include if tests are for non OOP code

class UserTest extends PHPUnit\Framework\TestCase
{

 protected function setUp(): void
 {
  $dataDir = DATA_DIR;
  $jsonDir = JSON_DIR;

  foreach (glob("{$dataDir}/{$jsonDir}/*") as $file) {
   unlink($file);
  };
 }

 /** @test */
 public function set_User_Should_Create_A_Instance_Of_The_User()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $hashPassword = "dummyHashPassword";
  $email = "dummyEmail";

  // act
  $assert = User::set($appname, $nickname, $hashPassword, $email);

  // assert
  $this->assertEquals($appname, $assert->entity->appname);
  $this->assertEquals($nickname, $assert->entity->nickname);
  $this->assertEquals($hashPassword, $assert->entity->hashPassword);
  $this->assertEquals($email, $assert->entity->email);
 }

 /** @test */
 public function get_User_Should_Return_A_User()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $hashPassword = "dummyHashPassword";
  $email = "dummyEmail";
  $createdTimestamp = date("d-m-Y H:i:s");
  User::set($appname, $nickname, $hashPassword, $email);

  // act
  $assert = User::get($appname, $nickname);

  // assert
  $this->assertEquals($appname, $assert->entity->appname);
  $this->assertEquals($nickname, $assert->entity->nickname);
  $this->assertEquals($hashPassword, $assert->entity->hashPassword);
  $this->assertEquals($email, $assert->entity->email);
  $this->assertNotEmpty($assert->entity->activationCode);
  $this->assertEquals(State::Newcomer, $assert->entity->state);
  $this->assertEqualsWithDelta($createdTimestamp, $assert->entity->createdTimestamp, 1);
  $this->assertNotEmpty($assert->entity->id);
 }

 /** @test */
 public function getFilename_Should_Return_The_Filename()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $user = new User();

  // act
  $assert = $user->getFilename($appname, $nickname);

  // assert
  $this->assertEquals("datatest/json/$appname-$nickname.json", $assert);
 }

 /** @test */
 public function load_Should_Load_A_User()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $hashPassword = "dummyHashPassword";
  $email = "dummyEmail";
  $createdTimestamp = date("d-m-Y H:i:s");
  User::set($appname, $nickname, $hashPassword, $email);
  $assert = new User();

  // act
  $assert->load($appname, $nickname);

  // assert
  $this->assertEquals($appname, $assert->entity->appname);
  $this->assertEquals($nickname, $assert->entity->nickname);
  $this->assertEquals($hashPassword, $assert->entity->hashPassword);
  $this->assertEquals($email, $assert->entity->email);
  $this->assertNotEmpty($assert->entity->activationCode);
  $this->assertEquals(State::Newcomer, $assert->entity->state);
  $this->assertEqualsWithDelta($createdTimestamp, $assert->entity->createdTimestamp, 1);
  $this->assertNotEmpty($assert->entity->id);
 }

 /** @test */
 public function save_Should_Save_The_User_To_A_File()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $hashPassword = "dummyHashPassword";
  $email = "dummyEmail";

  $user = new User();

  // act
  $user->save($appname, $nickname, $hashPassword, $email);
  $assert = file_exists($user->getFilename($appname, $nickname));

  // assert
  $this->assertTrue($assert);
 }

 /** @test */
 public function checkHashPassword_Should_Return_True__When_The_Password_Matched_The_HashPassword()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $password = "dummyPassword";
  $hashPassword = password_hash($password, PASSWORD_DEFAULT);
  $email = "dummyEmail";
  $user = User::set($appname, $nickname, $hashPassword, $email);

  // act
  $assert = $user->checkHashPassword($password);

  // assert
  $this->assertTrue($assert);
 }

/** @test */
 public function checkHashPassword_Should_Return_False_When_The_Password_Doesnt_Matched_The_HashPassword()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $password = "dummyPassword";
  $hashPassword = password_hash($password, PASSWORD_DEFAULT);
  $email = "dummyEmail";
  $user = User::set($appname, $nickname, $hashPassword, $email);
  $wrongPassword = "wrongPassword";

  // act
  $assert = $user->checkHashPassword($wrongPassword);

  // assert
  $this->assertFalse($assert);
 }

 /** @test */
 public function activate_Should_Return_True_When_The_activationCode_Is_Matched()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $password = "dummyPassword";
  $hashPassword = password_hash($password, PASSWORD_DEFAULT);
  $email = "dummyEmail";
  $user = User::set($appname, $nickname, $hashPassword, $email);
  $activationCode = $user->entity->activationCode;

  // act
  $assert = $user->activate($activationCode);

  // assert
  $this->assertTrue($assert);
 }

 /** @test */
 public function activate_Should_Return_False_When_The_activationCode_Is_Not_Matched()
 {
  // arrange
  $appname = "dummyAppname";
  $nickname = "dummyNickname";
  $password = "dummyPassword";
  $hashPassword = password_hash($password, PASSWORD_DEFAULT);
  $email = "dummyEmail";
  $user = User::set($appname, $nickname, $hashPassword, $email);
  $activationCode = "dummyActivationCode";

  // act
  $assert = $user->activate($activationCode);

  // assert
  $this->assertFalse($assert);
 }

 /** @test */
 public function isset_Should_Return_False_When_Entity_Is_Not_Set()
 {
  // arrange
  $user = new User();
  
  // act
  $result = $user->isset();

  // assert
  $this->assertFalse($result);
 }

 /** @test */
 public function isset_Should_Return_True_When_Entity_Is_Set()
 {
  // arrange
  $user = new User();
  $user->entity = "dummyEmpty";
  
  // act
  $result = $user->isset();

  // assert
  $this->assertTrue($result);
 }

}
