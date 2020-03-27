<?php namespace Elpida;

require_once("Constant.php");

date_default_timezone_set('Europe/Amsterdam');

class Id {
    
    public $id,
           $key;
   
    function __construct($key){        
        $this->id = 1;
        $this->key = $key;
    }
}

class Ids {
  private static $instance = null;

  public 
      $list = [],
      $filename = DATA_DIR."/".JSON_DIR."/id.json";
  
  private function __construct()
  {
    if(file_exists($this->filename))
    {
      $str = file_get_contents($this->filename);
      $this->list = json_decode($str);
    }
  }
  
  public static function new()
  {
    if (self::$instance == null)
    {
      self::$instance = new Ids();
    }
 
    return self::$instance;
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
      $this->save();
  }  

  public function getId($key){
    foreach($this->list as $item)
    {
      if($item->key == $key){
        return $item;
        }
    }
    return null;
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