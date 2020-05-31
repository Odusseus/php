<?php
use Items\Cookie;

date_default_timezone_set('Europe/Amsterdam');

include '/Githup/Odusseus/php/items/elpida/source/Cookie.php'; // must include if tests are for non OOP code

class CookieTest extends PHPUnit\Framework\TestCase
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
 public function isSet_Should_Return_False_When_Entity_Is_Not_set()
 {
  // arrange
  $cookie = new Cookie();

  // act
  $assert = $cookie->isSet();

  // assert
  $this->assertFalse($assert);
 }

 /** @test */
 public function isSet_Should_Return_True_When_Entity_Is_set()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);

  // act
  $assert = $cookie->isSet();

  // assert
  $this->assertTrue($assert);
 }

 /** @test */
 public function get_Should_Return_Cookie_Data()
 {
  // arrange
  $timestamp = date("d-m-Y H:i:s");
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);

  // act
  $assert = Cookie::get($cookie->entity->cookie);

  // assert
  $this->assertEquals($appname, $assert->entity->appname);
  $this->assertEquals($nickname, $assert->entity->nickname);
  $this->assertEquals($cookie->entity->cookie, $assert->entity->cookie);
  $this->assertEqualsWithDelta($timestamp, $assert->entity->timestamp, 1);
 }

 /** @test */
 public function get_Should_Return_Null_When_Cookiefile_Is_Not_Found()
 {
  // arrange
  $cookieValue = "dummyCookie";

  // act
  $assert = Cookie::get($cookieValue);

  // assert
  $this->assertNull($assert);
 }

 /** @test */
 public function getFilename_Should_Return_The_Filename()
 {
  // arrange
  $cookie = "123";

  // act
  $assert = Cookie::getFilename($cookie);

  // assert
  $this->assertEquals($assert, "sb/datatest/json/123-cookie.json");
 }

 /** @test */
 public function delete_Should_Run_Without_Error_Even_If_EntiTy_Is_Empty()
 {
  // arrange
  $cookie = new Cookie();

  // act
  $cookie->delete();

  // assert
  $this->assertEquals(true, true);
 }

 /** @test */
 public function delete_Should_Run_Without_Error_Even_If_The_File_Does_Not_Exist()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);
  $filename = Cookie::getFilename($cookie->entity->cookie);
  unlink($filename);

  // act
  $cookie->delete();

  // assert
  $this->assertEquals(true, true);
 }

 /** @test */
 public function delete_Should_Delete_The_File()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);

  // act
  $cookie->delete();

  // assert
  $this->assertEquals(true, true);
 }

 /** @test */
 public function isSet_Should_False_If_The_Entity_Is_Not_Set()
 {
  // arrange
  $cookie = new Cookie();

  // act
  $assert = $cookie->isSet();

  // assert
  $this->assertFalse($assert);
 }

 /** @test */
 public function isSet_Should_True_If_The_Entity_Is_Set()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);

  // act
  $assert = $cookie->isSet();

  // assert
  $this->assertTrue($assert);
 }

 /** @test */
 public function load_Should_Run_Without_Error_When_The_File_Is_Not_Found()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);
  $dummyCookie = "123";

  // act
  $cookie->load($dummyCookie);

  // assert
  $this->assertTrue(true);
 }

/** @test */
 public function load_Should_Set_The_Entity_When_The_Cookie_Is_Found()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);
  $cookieValue = $cookie->entity->cookie;
  $cookie->entity = null;

  // act
  $cookie->load($cookieValue);

  // assert
  $this->assertEquals($cookieValue, $cookie->entity->cookie);
 }

/** @test */
 public function save_Should_A_Cookie()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = new Cookie();

  // act
  $timestamp = date("d-m-Y H:i:s");
  $cookie->save($appname, $nickname);
  $cookieValue = $cookie->entity->cookie;
  $cookie->entity = null;
  $cookie->load($cookieValue);

  // assert
  $this->assertEquals($appname, $cookie->entity->appname);
  $this->assertEquals($nickname, $cookie->entity->nickname);
  $this->assertEquals($cookieValue, $cookie->entity->cookie);
  $this->assertEqualsWithDelta($timestamp, $cookie->entity->timestamp, 1);

 }

}
