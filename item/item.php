<?php
require_once("constant.php");
require_once("common.php");
require_once("entity.php");

class Item extends Entity{
    
    public $key,
           $code;
   
    function __construct($key, $code, $name){
        parent::__construct($name);
        if(!isset($key))
        {
            $key = GUID(); 
        }

        if(!isset($code))
        {
            $code = GUID(); 
        }
        $this->key = $key;
        $this->code = $code;
    }

    function saveValue($value)
    {
        $filename = "value/{$this->key}.txt";
        $file = fopen($filename, "wb") or die("Unable to open file!");
        fwrite($file, $value);
        fclose($file);
    }  
}

class Items extends Entities {

    function __construct() {
        parent::__construct(ITEM);
    }

  public function getItem($key, $code){
    foreach($this->list as $item)
    {
      if($item->key == $item and $item->code == $code){
        return $item;
        }
    }
    return "No items";
  }
}
