<?php

require_once("constant.php");
require_once("common.php");

class Ip extends Entity {

    function __construct(){
        parent::__construct(get_client_ip());
    }
}

class Ips extends Entities {

    function __construct() {
        parent::__construct(IP);
    }    
}
?>