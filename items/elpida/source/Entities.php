<?php namespace Items;

require_once("Constant.php");
require_once("Entity.php");
require_once("Ids.php");

class Entities {

    public 
        $list = [],
        $filename = "",
        $entityname = "";
    
    public function __construct($entityname){
        $this->entityname = $entityname; 
        $this->filename = DATA_DIR."/".JSON_DIR."/{$entityname}.json";
        if(file_exists($this->filename)){
            $str = file_get_contents($this->filename);
            $this->list = json_decode($str);
            $list = [];
            foreach($this->list AS $element => $data)
            {
              $class = new Entity($data->key);
              $class->set($data);
              array_push($list, $class);
            }
            $this->list = $list;
        }
    }

    public function save() {
        $json = json_encode($this->list, JSON_FORCE_OBJECT);
        file_put_contents($this->filename, $json, LOCK_EX);
    }
  
    public function delete(){
        if(file_exists($this->filename))
        {
            unlink($this->filename);
        }
        $this->list = [];
    }
  
    public function add($item){
        $ids = Ids::new();
        
        if(!$ids->getId($this->entityname))
        {
            $idItem = new Id($this->entityname);
            $ids->add($idItem);
            $id = $idItem->id;
        }
        else {
            $id = $ids->next($this->entityname);
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

