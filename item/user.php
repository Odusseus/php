<?php

require_once("constant.php");
require_once("id.php");
require_once("entity.php");

class User extends Entity {

    function __construct($key) {
        parent::__construct($key);
    }
}

class Users extends Entities {

    private static $instance = null;

    private function __construct() {
        parent::__construct(USER);
    }

    public static function new()
    {
        if (self::$instance == null)
        {
            self::$instance = new Users();
        } 
        return self::$instance;
    }
}
