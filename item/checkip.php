<?php

require_once("ips.php");

class CheckIp {

  public $isGood,
         $ipItem,
         $badIp;
   
  function __construct(){
    $this->badIp = new Ips();
    $this->ipItem = new Ip();
    if($this->badIp->getName($this->ipItem->name)){
      exit("Bad ip ".$this->ipItem->name);
    }
    $this->isGood = true;
  }

  public function addBadIp(){
    $this->badIp->add($this->ipItem);
    $this->badIp->save();
    exit("Added bad ip ".$this->ipItem->name);
  }
}

?>