<?php namespace Elpida;

require_once("Constant.php");

class IdMax {

  public $filename;

  function __construct($name){  
    $this->filename = DATA_DIR."/".TXT_DIR."/{$name}-id.txt";      
  }

  public function delete(){
    if(file_exists($this->filename))
    {
        unlink($this->filename);
    }
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
    $this->set($id);
  }

  public function set($id){    
    file_put_contents($this->filename, $id, LOCK_EX);
  }
}


?>