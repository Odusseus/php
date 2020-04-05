<?php namespace Elpida;

date_default_timezone_set('Europe/Amsterdam');

class Entity {
    
    public $id,
           $key,
           $timestamp;
   
    function __construct($key){
        $this->key = $key;
        $this->timestamp = date("d-m-Y H:i:s");
    }

    // TODO is that correct?
    //public function set($data) {
    //    foreach ($data AS $key => $value) $this->{$key} = $value;
    //}
}

?>

