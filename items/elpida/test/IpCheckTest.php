<?php
use Elpida\IpCheck;
use Elpida\Ids;
use Elpida\Ips;

include('/Githup/Odusseus/php/items/elpida/source/IpCheck.php');

class IpCheckTest extends PHPUnit\Framework\TestCase
{
  protected  function setUp(): void
  {
    Ids::delete();
    $ips = Ips::new();
    $ips->delete();
  }
  
  /** @test */
  public function new_Ips_Should_Returns_A_Singleton()
  {
    // arrange  
    
    // act
    $assert = new IpCheck();
    
    // assert
    $this->assertNotNull($assert);
    $this->assertTrue($assert->isGood);
  }
   
}

?>