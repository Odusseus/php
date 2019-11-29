<?php

require_once("constant.php");

date_default_timezone_set('Europe/Amsterdam');

class User {
    
    public $name,
           $timestamp;
   
    function __construct($name){        
        $this->name = $name;
        $this->timestamp = date("d-m-Y H:i:s");
    }
}

class Users {

  public 
      $list = [],
      $filename = "json/user.json";
  
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

  public function add($item){
      $this->list[] = $item;
  }  

  public function getUser($name){
    foreach($this->list as $item)
    {
      if($item->name == $name){
        return $item;
        }
    }
    return null;
  }

  public function getList(){
      return $this->list;
  }
}
