<?php

require_once("constant.php");
require_once("common.php");

date_default_timezone_set('Europe/Amsterdam');

class Ip {
    public $ip,
           $timestamp;

    function __construct(){
        $this->ip = get_client_ip();
        $this->timestamp = date("d-m-Y H:i:s");
    }
}

?>