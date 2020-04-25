<?php
use Items\ItemGetApi;

date_default_timezone_set('Europe/Amsterdam');

include('/Githup/Odusseus/php/items/elpida/source/ItemGetApi.php'); // must include if tests are for non OOP code

class ItemGetApiTest extends PHPUnit\Framework\TestCase
{  
  /** @test */
  public function itemGetApi_Should_Return_Is_A_Live_When_Ask()
  {
    // arrange  
 
    // $url = "http://local.elpida.odusseus.org/itemGetApi.php";
 
    // $client = curl_init($url);
    // curl_setopt($client,CURLOPT_RETURNTRANSFER,true);    
    
    // // act
    //$response = file_get_contents("http://local.elpida.odusseus.org/itemGetApi.php?isalive=true");
    $url = 'http://local.elpida.odusseus.org/itemGetApi.php?isalive=true';

    $response = get_headers($url);    

    // // assert
    $this->assertEquals($response, true);
    // $this->assertEquals($assert->key, Common::getClientIp());    
    // $this->assertEqualsWithDelta($assert->timestamp, $timestamp, 1);
  }  
}
?>
