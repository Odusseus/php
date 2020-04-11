<?php namespace Elpida;

require_once("Entity.php");

class Id extends Entity {
    
  function __construct($key){        
    parent::__construct($key);
    $this->id = 1;
  }
}
?>