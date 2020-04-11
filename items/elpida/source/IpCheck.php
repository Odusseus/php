<?php namespace Elpida;

require_once("Ips.php");

header('Access-Control-Allow-Origin: *');

class IpCheck {

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
    http_response_code(401);
    exit("Bad ip ".$this->ipItem->key." is added to the blacklist.");
  }
}

?>