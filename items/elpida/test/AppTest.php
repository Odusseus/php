<?php
use Elpida\App;

include('/Githup/Odusseus/php/items/elpida/source/App.php'); // must include if tests are for non OOP code

class AppTest extends PHPUnit\Framework\TestCase
{

  /** @test */
  public function CheckTest_Shoul_Return_True_When_Exist()
  {
    // arrange  
    $name = "test";

    // act
    $result = App::check($name);

    // assert
    $this->assertTrue($result);
  }

  /** @test */
  public function CheckTest_Shoul_Return_False_When_Not_Exist()
  {
    // arrange  
    $name = "toto";

    // act
    $result = App::check($name);

    // assert
    $this->assertFalse($result);
  }
}

?>
