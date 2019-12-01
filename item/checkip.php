<?php

require_once("ips.php");

class CheckIp {

  public $isGood,
         $ipItem,
         $badIp;
   
  function __construct(){
    $this->badIp = new Ips();
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