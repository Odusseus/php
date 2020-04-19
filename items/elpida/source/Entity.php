<?php namespace Items;

date_default_timezone_set('Europe/Amsterdam');

class Entity {
    
    public $id,
           $key,
           $timestamp;
   
    function __construct($key){
        $this->key = $key;
        $this->timestamp = date("d-m-Y H:i:s");
    }

    public function set($data) {
        foreach ($data AS $key => $value) $this->{$key} = $value;
    }
}

?>

