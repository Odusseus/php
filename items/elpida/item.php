<?php
require_once("constant.php");
require_once("common.php");
require_once("entity.php");

class Item{
    
    public $key,
           $value;
   
    function __construct($appname, $nickname){
      $key = "{$appname}-{$nickname}-item";     
      $this->appname = $appname;
      $this->nickname = $nickname;
      $this->getValue(); // TODO
    }

    function saveValue($value)
    {
        $filename = DATA_DIR."/".VALUE_DIR."/{$this->key}.txt";
        $file = fopen($filename, "wb") or die("Unable to open file!");
        fwrite($file, $value);
        fclose($file);
    } 

    function getValue()
    {
        $filename = DATA_DIR."/".VALUE_DIR."/{$this->key}.txt";
        if (file_exists($filename))
        {
            $file = fopen($filename, "rb");
        }
        else
        {
            http_response_code(500);
            die("Unable to open file!");
        }
        $this->value = fread($file, filesize($filename));
    } 
    
    function getJsonGetRespons()
    {
        $itemGetRespons = new ItemGetRespons($this);
        return json_encode($itemGetRespons);
    }

}

class ItemGetRespons
{
    public $value;

    public function __construct($item){
        $this->value = $value;
    }
}


?>
