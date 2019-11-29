<?php

require_once("badip.php");

class CheckIp {

  public $isGood,
         $ipItem,
         $badIp;
   
  function __construct(){
    $this->badIp = new BadIps();
    $this->ipItem = new Ip();
    if($this->badIp->isBadIp($this->ipItem)){
      exit("Bad ip ".$this->ipItem->ip);
    }
    $this->isGood = true;
  }

  public function addBadIp(){
    $this->badIp->add($this->ipItem);
    $this->badIp->save();
    exit("Added bad ip ".$this->ipItem->ip);
  }
}

?>