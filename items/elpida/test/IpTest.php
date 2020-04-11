<?php
use Elpida\Ip;
use Elpida\Common;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/Ip.php'); // must include if tests are for non OOP code

class IpTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function new_Id_Should_Create_A_Instance_Of_Ip()
  {
    // arrange  
    $timestamp = date("d-m-Y H:i:s");
    
    // act
    $assert = new Ip();

    // assert
    $this->assertEquals($assert->id, 0);
    $this->assertEquals($assert->key, Common::getClientIp());    
    $this->assertEqualsWithDelta($assert->timestamp, $timestamp, 1);
  }  
}
?>
