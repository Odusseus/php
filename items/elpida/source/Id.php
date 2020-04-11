<?php namespace Elpida;

class Id {
    
    public $id,
           $key;
   
    function __construct($key){        
        $this->id = 1;
        $this->key = $key;
    }
}
?>