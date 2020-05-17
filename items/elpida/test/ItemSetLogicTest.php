<?php
use Items\Cookie;
use Items\HttpCode;
use Items\ItemSetLogic;
use Items\User;

include '/Githup/Odusseus/php/items/elpida/source/ItemSetLogic.php';

class ItemSetLogicTest extends PHPUnit\Framework\TestCase
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
 public function setIsAlive_Should_Return_HttpResponse_Intance_With_IsAlive_State()
 {
  // arrange
  $itemSetLogic = new ItemSetLogic();

  // act
  $result = $itemSetLogic->getIsAlive();

  // assert
  $this->assertEquals(HttpCode::OK, $result->code);
  $this->assertEquals(STATE_TRUE, $result->message);
 }

/** @test */
 public function setItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_CookieValue_Is_Null()
 {
  // arrange
  $itemSetLogic = new ItemSetLogic();
  $cookieValue = null;
  $value = COOKIE;
  $message = "Cookie $value is missing.";
  $content = "dummy content";

  // act
  $result = $itemSetLogic->setItem($cookieValue, $content);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function setItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_CookieValue_Is_Empty_String()
 {
  // arrange
  $itemSetLogic = new ItemSetLogic();
  $cookieValue = "";
  $value = COOKIE;
  $message = "Cookie $value is missing.";
  $content = "dummy content";

  // act
  $result = $itemSetLogic->setItem($cookieValue, $content);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function setItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_Cookiefile_Is_Missing()
 {
  // arrange
  $itemSetLogic = new ItemSetLogic();
  $cookieValue = "123";
  $message = "Cookie $cookieValue is not found.";
  $content = "dummy content";

  // act
  $result = $itemSetLogic->setItem($cookieValue, $content);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function setItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_User_Is_Missing()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);
  $content = "dummy content";

  $itemSetLogic = new ItemSetLogic();
  $message = "User is missing.";

  // act
  $result = $itemSetLogic->setItem($cookie->entity->cookie, $content);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code);
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function setItem_Should_Return_HttpResponse_NOT_FOUND_When_Version_Is_Missing()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $hashPassword = "hashPassword";
  $email = "email@mail.com";
  $user = User::set($appname, $nickname, $hashPassword, $email);

  $cookie = Cookie::set($appname, $nickname);
  $content = '{"value":"toto tata titi tutu"}';
  $value = VERSION;
  $message = "$value is missing.";
  $itemSetLogic = new ItemSetLogic();

  // act
  $result = $itemSetLogic->setItem($cookie->entity->cookie, $content);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->code, );
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function setItem_Should_Return_HttpResponse_BAD_REQUEST_When_Version_Is_Obsolete()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $hashPassword = "hashPassword";
  $email = "email@mail.com";
  $user = User::set($appname, $nickname, $hashPassword, $email);

  $cookie = Cookie::set($appname, $nickname);
  $content = '{"value":"toto tata titi tutu", "version":0}';
  $message = "version 0 is obsolete. Refresh the your item.";
  $itemSetLogic = new ItemSetLogic();
  
  // act
  $result = $itemSetLogic->setItem($cookie->entity->cookie, $content);
  $result = $itemSetLogic->setItem($cookie->entity->cookie, $content);

  // assert
  $this->assertEquals(HttpCode::BAD_REQUEST, $result->code, );
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function setItem_Should_Return_HttpResponse_OK_When_Item_Is_Saved()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $hashPassword = "hashPassword";
  $email = "email@mail.com";
  $user = User::set($appname, $nickname, $hashPassword, $email);

  $cookie = Cookie::set($appname, $nickname);
  $content = '{"value":"toto tata titi tutu", "version":0}';
  $message = 'Item is saved.';
  $itemSetLogic = new ItemSetLogic();  

  // act
  $result = $itemSetLogic->setItem($cookie->entity->cookie, $content);  

  // assert
  $this->assertEquals(HttpCode::OK, $result->code, );
  $this->assertEquals($message, $result->message);  
 } 
}
