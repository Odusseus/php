<?php namespace Items;

require_once("Ip.php");
require_once("Ips.php");
require_once("enum/Error.php");

class IpCheck {

  public $isGood,
         $ipItem,
         $badIp;
   
  function __construct(){
    $this->badIp = Ips::new();
    $this->ipItem = new Ip();
    if($this->badIp->getKey($this->ipItem->key)){
      $this->isGood = false;
      error_log(Error::BadIP." {$this->ipItem->key}", 0);
    }
    $this->isGood = true;
  }

  public function addBadIp(){
    $this->isGood = false;
    $this->badIp->add($this->ipItem);    
  }
}

?>