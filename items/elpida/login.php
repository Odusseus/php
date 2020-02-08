<?php

class Login {
  public $userFilename,
         $cookieFilename;
  
  function __construct($userFilename){
    $this->userFilename = $userFilename;
  }
}


?>