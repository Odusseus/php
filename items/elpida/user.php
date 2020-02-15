<?php

require_once("abstract/state.php");

class User {
  public $nickname,
         $password,
         $email,
         $activationCode,
         $state,
         $createdTimestamp;  
  
  function set($nickname, $password, $email){
    $this->nickname = $nickname;
    $this->password = $password;
    $this->email = $email;
    $this->state = State::Newcomer;
    $this->activationCode = rand(1000, 9999);
    $this->activationCodeExpired = date("d-m-Y H:i:s", strtotime("+1 week"));
    $this->createdTimestamp = date("d-m-Y H:i:s");
  }

  function activate($activationCode){
    if($this->activationCode == $activationCode){
      $this->state = State::Active;
      return true;
    }
    return false;
  }
}
?>