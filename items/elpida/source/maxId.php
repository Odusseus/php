<?php

require_once("constant.php");

class MaxId {

  private  $filename;

  function __construct($name){  
    $this->filename = DATA_DIR."/".TXT_DIR."/{$name}.txt";      
  }

  public function get(){
    if(file_exists($this->filename)){
      $str = file_get_contents($this->filename);
      return (int)$str;
    }
    else 
    {
      return 0;
    }
  }

  public function next(){
    if(file_exists($this->filename)){
      $str = file_get_contents($this->filename);
      $id = (int)$str;
      $id++;
    }
    else 
    {
      $id = 1;
    }
    file_put_contents($this->filename, $id, LOCK_EX);
  }

  public function set($id){    
    file_put_contents($this->filename, $id, LOCK_EX);
  }
}


?>