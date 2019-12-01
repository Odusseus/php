<?php

require_once("constant.php");
require_once("id.php");

date_default_timezone_set('Europe/Amsterdam');

class Entity {
    
    public $id,
           $key,
           $timestamp;
   
    function __construct($key){
        $this->key = $key;
        $this->timestamp = date("d-m-Y H:i:s");
    }
}

class Entities {

    public 
        $list = [],
        $filename = "",
        $entity = "";
    
    function __construct($entity){
        $this->entity = $entity; 
        $this->filename = JSON_DIR."/{$entity}.json";
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
        $ids = new Ids();
        
        if(!$ids->getId($this->entity)){
            $idItem = new Id($this->entity);
            $ids->add($idItem);
            $id = $idItem->id;
        }
        else {
            $id = $ids->next($this->entity);
        }
        $item->id = $id;
        $this->list[] = $item;
        $this->save();
    }  
  
    public function getKey($key){
      foreach($this->list as $item)
      {
        if($item->key == $key){
          return $item;
          }
      }
      return null;
    }
  
    public function getId($id){
      foreach($this->list as $item)
      {
        if($item->id == $id){
          return $item;
          }
      }
      return null;
    }
  
    public function getList(){
        return $this->list;
    }
}
?>

