<?php namespace Items;

require_once("Constant.php");
require_once("Entities.php");

class Ips extends Entities 
{
    private static $instance = null;

    public function __construct() {
        parent::__construct(BADIP);
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