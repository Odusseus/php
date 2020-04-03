<?php
use Elpida\Cookie;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/Cookie.php'); // must include if tests are for non OOP code

class CookieTest extends PHPUnit\Framework\TestCase
{

  protected  function setUp(): void
    {
      $dataDir =  DATA_DIR;

      foreach(glob("{$dataDir}/json/*") as $f) {
        unlink($f);
      };

      foreach(glob("{$dataDir}/mail/*") as $f) {        
        unlink($f);
      }

      foreach(glob("{$dataDir}/txt/*") as $f) {        
        unlink($f);
      }

      foreach(glob("{$dataDir}/value/*") as $f) {        
        unlink($f);
      }
    }

  /** @test */
  public function isSet_Shoul_Return_False_When_Entity_Is_Not_set()
  {
    // arrange  
    $cookie = new Cookie();
    
    // act
    $assert = $cookie->isSet();

    // assert
    $this->assertFalse($assert);
  }
  
  /** @test */
  public function isSet_Shoul_Return_True_When_Entity_Is_set()
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
  public function get_Shoul_Return_Cookie_Data()
  {
    // arrange  
    $appname = "appname ";
    $nickname = "nickname";
    $cookie = Cookie::set($appname, $nickname);
    
    // act
    $assert = $cookie->get($cookie->entity->cookie);

    // assert
    $this->assertEquals($assert->entity->appname, $appname);
    $this->assertEquals($assert->entity->nickname, $nickname); 
    $this->assertEquals($assert->entity->cookie, $cookie->entity->cookie); 
    $this->assertNotEmpty($assert->entity->timestamp);
  }
}
?>
