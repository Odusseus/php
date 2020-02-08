<?php

class User {
  public $nickname,
         $password,
         $email,
         $activationCode,
         $state,
         $createdTimestamp;
  
  function __construct($nickname, $password, $email){
    $this->nickname = $nickname;
    $this->password = $password;
    $this->email = $email;
    $this->state = State::Newcomer;
    $this->activationCode = rand(1000, 9999);
    $this->activationCodeExpired = date("d-m-Y H:i:s", strtotime("+1 week"));
    $this->createdTimestamp = date("d-m-Y H:i:s");
  }
}


?>