<?php namespace Items;

require_once("Constant.php");
require_once("Entities.php");

class Ips extends Entities 
{
    private static $instance = NULL;

    public function __construct() {
        parent::__construct(BADIP);
    } 
    
    public static function new()
    {
        if (empty(self::$instance))
        {
            self::$instance = new Ips();
        }
 
        return self::$instance;
    }
}
?>