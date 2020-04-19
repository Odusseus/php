<?php
use Items\Ip;
use Items\Ips;
use Items\Id;
use Items\Ids;

include('/Githup/Odusseus/php/items/elpida/source/Ip.php');
include('/Githup/Odusseus/php/items/elpida/source/Ips.php');

class IpsTest extends PHPUnit\Framework\TestCase
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
    $assert1 = Ips::new();
    $assert2 = Ips::new();

    // assert
    $this->assertNotNull($assert1);
    $this->assertNotNull($assert2);
    $this->assertEquals($assert1, $assert2);
  }
  
  /** @test */
  public function add_Ips_Should_Add_A_Ip_To_The_BadList()
  {
    // arrange  
    $ids = Ids::new();
    $id1 = new Id("ABC");
    $id2 = new Id("DEF");
    $ids->add($id1);
    $ids->add($id2);
    
    $ip1 = new Ip();
    $ip2 = new Ip();
    $assert = Ips::new();
    
    
    
    // act
    $assert->add($ip1);
    $assert->add($ip2);
    $assertIds = Ids::new();

    // assert
    $this->assertEquals(count($assert->list), 2);
    $this->assertEquals(count($assertIds->list), 3);
  }


}

?>