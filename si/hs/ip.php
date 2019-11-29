<?php

require_once("constant.php");
require_once("common.php");

date_default_timezone_set('Europe/Amsterdam');

class Ip {
    public $ip,
           $timestamp,
           $type,
           $message;

    function __construct($type, $message){
        $this->ip = get_client_ip();
        $this->type = $type;
        $this->message = $message;
        $this->timestamp = date("d-m-Y H:i:s");
    }
}

?>