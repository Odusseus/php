<?php
use Items\Constant;
use Items\IpCheck;
use Items\Ids;
use Items\Ips;

include('/Githup/Odusseus/php/items/elpida/source/IpCheck.php');

class IpCheckTest extends PHPUnit\Framework\TestCase
{
  protected  function setUp(): void
  {
    Ids::delete();
    $ips = Ips::new();
    $ips->delete();

    $errorLogFile = "log/php_errors.log";
    if(file_exists($errorLogFile))
    {
      unlink($errorLogFile);
    }
  }
  
  /** @test */
  public function new_IpCheck_Should_Returns_A_Instantie()
  {
    // arrange  
    
    // act
    $assert = new IpCheck();
    
    // assert
    $this->assertNotNull($assert);
    $this->assertTrue($assert->isGood);
  }

  /** @test */
  public function checkIp_Should_Log_When_The_IP_Was_Already_Knows()
  {
    // arrange  
    $ipCheck = new IpCheck();
    $ipCheck->addBadIp();
    
    // act
    $ipCheck1 = new IpCheck();
    $errorLogFile = "log/php_errors.log";
    $assert = file_exists("log/php_errors.log");
    
    // assert
    $this->assertTrue($assert);
  }
   
}

?>