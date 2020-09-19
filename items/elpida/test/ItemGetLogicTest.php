<?php
use Items\Cookie;
use Items\HttpCode;
use Items\Item;
use Items\ItemGetLogic;
use Items\User;

include '/Githup/Odusseus/php/items/elpida/source/ItemGetLogic.php';

class ItemGetLogicTest extends PHPUnit\Framework\TestCase
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
 public function getIsAlive_Should_Return_HttpResponse_Intance_With_IsAlive_State()
 {
  // arrange
  $itemGetLogic = new ItemGetLogic();

  // act
  $result = $itemGetLogic->getIsAlive();

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals(STATE_TRUE, $result->message);
 }

/** @test */
 public function getItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_CookieValue_Is_Null()
 {
  // arrange
  $itemGetLogic = new ItemGetLogic();
  $cookieValue = null;
  $value = COOKIE_TOKEN;
  $message = "Cookie $value is missing.";

  // act
  $result = $itemGetLogic->getItem($cookieValue);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function getItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_CookieValue_Is_Empty_String()
 {
  // arrange
  $itemGetLogic = new ItemGetLogic();
  $cookieValue = "";
  $value = COOKIE_TOKEN;
  $message = "Cookie $value is missing.";

  // act
  $result = $itemGetLogic->getItem($cookieValue);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function getItem_Should_Return_HttpResponse_Intance_With_State_Unauthorized_When_Cookiefile_Is_Missing()
 {
  // arrange
  $itemGetLogic = new ItemGetLogic();
  $cookieValue = "123";
  $message = "Cookie $cookieValue is unauthorised.";

  // act
  $result = $itemGetLogic->getItem($cookieValue);

  // assert
  $this->assertEquals(HttpCode::UNAUTHORIZED, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function getItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_User_Is_Missing()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $cookie = Cookie::set($appname, $nickname);

  $itemGetLogic = new ItemGetLogic();
  $message = "User is missing.";

  // act
  $result = $itemGetLogic->getItem($cookie->entity->cookie);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function getItem_Should_Return_HttpResponse_Intance_With_State_Not_Found_When_Item_Is_Missing()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $hashPassword = "hashPassword";
  $email = "email@mail.com";
  $user = User::set($appname, $nickname, $hashPassword, $email);

  $cookie = Cookie::set($appname, $nickname);

  $itemGetLogic = new ItemGetLogic();
  $message = "Item is missing.";

  // act
  $result = $itemGetLogic->getItem($cookie->entity->cookie);

  // assert
  $this->assertEquals(HttpCode::NOT_FOUND, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function getItem_Should_Return_HttpResponse_Intance_With_Item_When_Item_Is_Found()
 {
  // arrange
  $appname = "appname ";
  $nickname = "nickname";
  $hashPassword = "hashPassword";
  $email = "email@mail.com";
  $user = User::set($appname, $nickname, $hashPassword, $email);

  $cookie = Cookie::set($appname, $nickname);
  Item::set($user->entity->id,"123", 0);

  $message = '{"value":"123","version":0}' ;

  $itemGetLogic = new ItemGetLogic();
  // act
  $result = $itemGetLogic->getItem($cookie->entity->cookie);

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode, );
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function getLength_Should_Return_HttpResponse_Intance_With_Item_Length()
 {
  // arrange
  $itemGetLogic = new ItemGetLogic();
  $item = "0123456789";
  $message =  "10 bytes, 0.1%.";

  // act
  $result = $itemGetLogic->getLength($item);

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

/** @test */
 public function getLength_Should_Return_HttpResponse_Intance_With_Item_Length_Is_0_Bytes_When_Item_Is_Null()
 {
  // arrange
  $itemGetLogic = new ItemGetLogic();
  $item = null;
  $message =  "0 byte, 0%.";

  // act
  $result = $itemGetLogic->getLength($item);

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }

 /** @test */
 public function getMaxLength_Should_Return_HttpResponse_Intance_With_Item_Max_Length()
 {
  // arrange
  $itemGetLogic = new ItemGetLogic();
  $message =  "10000 bytes.";

  // act
  $result = $itemGetLogic->getMaxLength();

  // assert
  $this->assertEquals(HttpCode::OK, $result->statusCode);
  $this->assertEquals($message, $result->message);
 }
}
