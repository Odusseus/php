<?php
 class UserEntity {
   public $nickname,
          $hashPassword,
          $email,
          $activationCode,
          $state,
          $createdTimestamp;  
  
   function set($nickname, $hashPassword, $email){
     $this->nickname = $nickname;
     $this->hashPassword = $hashPassword;
     $this->email = $email;
     $this->state = State::Newcomer;
     $this->activationCode = rand(1000, 9999);
     $this->activationCodeExpired = date("d-m-Y H:i:s", strtotime("+1 week"));
     $this->createdTimestamp = date("d-m-Y H:i:s");

     $json = serialize($user);
     $userFilename = DATA_DIR."/".JSON_DIR."/{$this->$nickname}.json";
     file_put_contents($userFilename, $json, LOCK_EX);
    
     $login = new Login("{$this->$nickname}.json");
     $json = serialize($login);
     file_put_contents($loginFilename, $json, LOCK_EX);
   }

   function get($nickname){
     $this->nickname = $nickname;
     $this->hashPassword = $hashPassword;
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