<?php namespace Items;
  require_once("Constant.php");
  
  class App {
    static function check($name){
      $apps = array();
      if(DEBUG) {  
        array_push($apps, 'test');
      }
      array_push($apps, 'voca');
      array_push($apps, 'VocaQuiz');

      if (in_array($name, $apps)) {
        return true;
      }
      return false;
    }
  }
?>