<?php namespace Items;

require_once("Constant.php");
require_once("Id.php");

class Ids {
  private static $instance = NULL;
  public static $filename = DATA_DIR."/".JSON_DIR."/".ID.".json";

  public $list = [];
  
  private function __construct()
  {
    if(file_exists(self::$filename))
    {
      $str = file_get_contents(self::$filename);
      $this->list = json_decode($str);
    }
  }

  public static function isSet()
  {
    if (!empty(self::$instance))
    {
      return true;
    }
    
    return false;
  }
  
  public static function new()
  {
    if (empty(self::$instance) || !file_exists(self::$filename))
    {
      self::$instance = new Ids();
    }
    
    return self::$instance;
  }
  
  public static function delete(){
      if(file_exists(self::$filename))
      {
        unlink(self::$filename);
      }
      self::$instance = NULL;
  }

  public function save() {
      $json = json_encode($this->list, JSON_FORCE_OBJECT);
      file_put_contents(self::$filename, $json, LOCK_EX);      
  }


  public function add($item){
      $this->list[] = $item;
      $this->save();
  }  

  public function getId($key){
    foreach($this->list as $item)
    {
      if($item->key == $key){
        return $item;
        }
    }
    return NULL;
  }
  
  public function getList(){
      return $this->list;
  }

  public function next($key){
      $item = $this->getId($key);
      $item->id ++;
      $this->save();
      return $item->id; 
  }
}
?>