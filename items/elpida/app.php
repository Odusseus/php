<?php
  class App {
    static function check($name){
      $apps = array();  
      $apps[0] = 'test';

      if (in_array($name, $apps)) {
        return true;
      }
      return false;
    }
  }
?>