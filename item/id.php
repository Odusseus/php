<?php

require_once("constant.php");

date_default_timezone_set('Europe/Amsterdam');

class Id {
    
    public $id,
           $name;
   
    function __construct($name){        
        $this->id = 1;
        $this->name = $name;
    }
}

class Ids {

  public 
      $list = [],
      $filename = "json/id.json";
  
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

  public function getId($name){
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

  public function next($name){
      $item = $this->getId($name);
      $item->id ++;
      $this->save();
      return $item->id; 
  }
}
