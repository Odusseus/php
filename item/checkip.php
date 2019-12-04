<?php

require_once("ip.php");

class CheckIp {

  public $isGood,
         $ipItem,
         $badIp;
   
  function __construct(){
    $this->badIp = Ips::new();
    $this->ipItem = new Ip();
    if($this->badIp->getKey($this->ipItem->key)){
      exit("Bad ip ".$this->ipItem->key);
    }
    $this->isGood = true;
  }

  public function addBadIp(){
    $this->badIp->add($this->ipItem);
    exit("Added bad ip ".$this->ipItem->key);
  }
}

?>