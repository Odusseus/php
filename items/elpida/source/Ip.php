<?php namespace Elpida;

require_once("Constant.php");
require_once("Common.php");
require_once("Entity.php");

class Ip extends Entity {

    function __construct(){
        parent::__construct(Common::get_client_ip());
    }
}

class Ips extends Entities 
{
    private static $instance = null;

    public function __construct() {
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