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
    // $response = curl_exec($client);
    // $result = json_decode($response);

    // // assert
    // $this->assertEquals($assert->id, 0);
    // $this->assertEquals($assert->key, Common::getClientIp());    
    // $this->assertEqualsWithDelta($assert->timestamp, $timestamp, 1);
  }  
}
?>
