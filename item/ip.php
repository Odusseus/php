<?php

require_once("constant.php");
require_once("common.php");

class Ip extends Entity {

    function __construct(){
        parent::__construct(get_client_ip());
    }
}

class Ips extends Entities 
{
    private static $instance = null;

    private function __construct() {
        parent::__construct(IP);
    } 
    
    public static function new()
    {
        if (self::$instance == null)
        {
            self::$instance = new Ips();
        }
 
        return self::$instance;
    }
}
?>