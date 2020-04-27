<?php
use Items\CookieEntity;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/CookieEntity.php'); // must include if tests are for non OOP code

class CookieEntityTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function CookieEntity_Shoul_Be_Created_And_Set_With_Data()
  {
    // arrange  
    $appname = "appnametest";
    $nickname = "nicknametest";
    $cookie = "cookietest";
    $timestamp = date("d-m-Y H:i:s");
    
    // act
    $assert = new CookieEntity();
    $assert->appname = $appname;
    $assert->nickname = $nickname;
    $assert->cookie = $cookie;
    $assert->timestamp = $timestamp;   

    // assert
    $this->assertEquals($appname, $assert->appname);
    $this->assertEquals($nickname, $assert->nickname);
    $this->assertEquals($cookie, $assert->cookie);
    $this->assertEquals($timestamp, $assert->timestamp);

  }
}
?>
