<?php
use Items\Cookie;

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
    $assert = $cookie->get($cookie->entity->cookie);

    // assert
    $this->assertEquals($assert->entity->appname, $appname);
    $this->assertEquals($assert->entity->nickname, $nickname); 
    $this->assertEquals($assert->entity->cookie, $cookie->entity->cookie); 
    $this->assertEqualsWithDelta($assert->entity->timestamp, $timestamp, 1);
  }

  /** @test */
  public function getFilename_Should_Return_The_Filename()
  {
    // arrange  
    $cookie = "123";
    
    // act
    $assert = Cookie::getFilename($cookie);

    // assert
    $this->assertEquals($assert, "datatest/json/123-cookie.json");
  }

  /** @test */
  public function delete_Should_Run_Without_Error_Even_If_EntiTy_Is_Empty()
  {
    // arrange  
    $cookie = new Cookie();
  
    // act
    $cookie->delete();

    // assert
    $this->assertEquals(True, True);
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
    $this->assertEquals(True, True);
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
    $this->assertEquals(True, True);
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
    $this->assertTrue(True);
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
  $this->assertEquals($cookie->entity->cookie, $cookieValue);
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
  $this->assertEquals($cookie->entity->appname, $appname);
  $this->assertEquals($cookie->entity->nickname, $nickname);
  $this->assertEquals($cookie->entity->cookie, $cookieValue);
  $this->assertEqualsWithDelta($cookie->entity->timestamp, $timestamp, 1);

}



}
?>
