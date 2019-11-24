<?php

require_once("constant.php");

date_default_timezone_set('Europe/Amsterdam');

class Item {
    
    public $key,
           $code,
           $name,
           $timestamp;
   
    function __construct($key, $code, $name){
        $this->key = $key;
        $this->code = $code;
        $this->name = $name;
        $this->timestamp = date("d-m-Y H:i:s");
    }
}

class Items {

  public 
      $list = [],
      $filename = "item.json";
  
  function __construct(){
      if(file_exists($this->filename)){
          $str = file_get_contents($this->filename);
          $this->list = json_decode($str);
      }
  }
  
  public function getJson(){
      return json_encode($this->list);
  }

  public function save() {
      $str = json_encode($this->list);
      $myfile = fopen($this->filename, "w") or die("Unable to open file!");
      fwrite($myfile, $str);
      fclose($myfile);
  }

  public function delete(){
      unlink($this->filename);
  }

  public function push($item){
      $this->list[] = $item;
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

  public function getList(){
      return $this->list;
  }
}
