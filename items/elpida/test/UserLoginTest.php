<?php
use Items\UserLogin;

include '/Githup/Odusseus/php/items/elpida/source/UserLogin.php'; // must include if tests are for non OOP code

class UserLoginTest extends PHPUnit\Framework\TestCase
{

 protected function setUp(): void
 {
  $dataDir = DATA_DIR;
  $valueDir = JSON_DIR;

  foreach (glob("{$dataDir}/{$valueDir}/*") as $file) {
   unlink($file);
  };
 }

 /** @test */
 public function set_Should_Create_A_Instance_Of_The_UserLogin()
 {
  // arrange
  $appname = "test";
  $nickname = "testNickname";

  // act
  $return = UserLogin::set($appname, $nickname);

  // assert
  $this->assertNotNull($return);
 }

 /** @test */
 public function get_Item_Should_Return_A_Item()
 {
  // arrange
  $appname = "test";
  $nickname = "testNickname";
  UserLogin::set($appname, $nickname);

  // act
  $result = UserLogin::get($appname, $nickname);

  // assert
  $this->assertNotNull($result);
 }

 /** @test */
 public function getFilename_Should_Return_The_Filename()
 {
  // arrange
  $appname = "test";
  $nickname = "testNickname";
  $userLogin = new UserLogin();

  // act
  $result = $userLogin->getFilename($appname, $nickname);

  // assert
  $this->assertEquals("datatest/json/test-testNickname-login.json", $result);
 }

 /** @test */
 public function load_Should_Load_A_Entity()
 {
  // arrange
  $appname = "test";
  $nickname = "testNickname";
  $userLogin = UserLogin::set($appname, $nickname);
  $assert = $userLogin->entity;
  $userLogin->entity = null;

  // act
  $userLogin->load($appname, $nickname);

  // assert
  $this->assertEquals($assert->appname, $userLogin->entity->appname);
  $this->assertEquals($assert->nickname, $userLogin->entity->nickname);
  $this->assertEquals($assert->cookie, $userLogin->entity->cookie);
 }

 /** @test */
 public function save_Should_Save_The_New_Entity_To_A_File()
 {
  // arrange
  $appname = "test";
  $nickname = "testNickname";
  $userLogin = new UserLogin();

  // act
  $userLogin->save($appname, $nickname);
  $result = file_exists($userLogin->getFilename($appname, $nickname));
  // assert
  $this->assertTrue($result);
 }

 /** @test */
 public function save_Should_ReSave_The_Entity_To_A_File()
 {
  // arrange
  $appname = "test";
  $nickname = "testNickname";
  $userLogin = UserLogin::set($appname, $nickname);

  // act
  $userLogin->save($appname, $nickname);
  $result = file_exists($userLogin->getFilename($appname, $nickname));
  // assert
  $this->assertTrue($result);
 }

 /** @test */
 public function isSet_Should_Return_True_When_entity_Is_Set()
 {
  // arrange
  $appname = "test";
  $nickname = "testNickname";
  $userLogin = UserLogin::set($appname, $nickname);

  // act
  $result = $userLogin->isSet();

  // assert
  $this->assertTrue($result);
 }

 /** @test */
 public function isSet_Should_Return_False_When_entity_Is_Not_Set()
 {
  // arrange
  $userLogin = new UserLogin();

  // act
  $result = $userLogin->isSet();

  // assert
  $this->assertFalse($result);
 }




}
