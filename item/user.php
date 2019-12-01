<?php

require_once("constant.php");
require_once("id.php");
require_once("entity.php");

class User extends Entity {

    function __construct($name) {
        parent::__construct($name);
    }
}

class Users extends Entities {

    function __construct() {
        parent::__construct(USER);
    }
}
