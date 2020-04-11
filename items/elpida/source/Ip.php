<?php namespace Elpida;

require_once("Common.php");
require_once("Entity.php");

class Ip extends Entity {

    function __construct(){
        parent::__construct(Common::getClientIp());
    }
}

?>