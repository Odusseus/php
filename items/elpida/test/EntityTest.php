<?php
use Elpida\Entity;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/Entity.php'); // must include if tests are for non OOP code

class CookieEntityTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function new_Entity_Shoul_A_Instance_Of_Entity()
  {
    // arrange  
    $timestamp = date("d-m-Y H:i:s");
    $key = "ketsKey";
    
    // act
    $assert = new Entity($key);

    // assert
    $this->assertEquals($assert->appname, $appname);
    $this->assertEquals($assert->nickname, $nickname);
    $this->assertEquals($assert->cookie, $cookie);
    $this->assertEquals($assert->timestamp, $timestamp);

  }
}
?>
