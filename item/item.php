<?php
require_once("constant.php");
require_once("common.php");
require_once("entity.php");

class Item extends Entity{
    
    public $token,
           $userId;
   
    function __construct($key, $token, $userId){
        if(!isset($key))
        {
            $key = GUID(); 
        }
        parent::__construct($key);

        if(!isset($token))
        {
            $token = GUID(); 
        }
        $this->token = $token;
        $this->userId = $userId;
    }

    function saveValue($value)
    {
        $filename = "value/{$this->key}.txt";
        $file = fopen($filename, "wb") or die("Unable to open file!");
        fwrite($file, $value);
        fclose($file);
    } 

    function getValue()
    {
        $filename = "value/{$this->key}.txt";
        if (file_exists($filename))
        {
            $file = fopen($filename, "rb");
        }
        else
        {
            http_response_code(404);
            die("Unable to open file!");
        }
        $value = fread($file, filesize($filename));
        return $value;
    } 
    
    function getJsonPostRespons()
    {
        $itemPostRespons = new ItemPostRespons($this);
        return json_encode($itemPostRespons);
    }

    function getJsonGetRespons()
    {
        $itemGetRespons = new ItemGetRespons($this);
        return json_encode($itemGetRespons);
    }

    function getTokenGetRespons()
    {
        $tokenGetRespons = new TokenGetRespons($this);
        return json_encode($tokenGetRespons);
    }    
}

class ItemPostRespons
{
    public $key,
           $token;

    public function __construct($item){
        $this->key = $item->key;
        $this->token = $item->token;
    }
}

class ItemGetRespons
{
    public $key,
           $token,
           $value;

    public function __construct($item){
        $this->key = $item->key;
        $this->token = $item->token;
        $this->value = $item->getValue();
    }
}

class TokenGetRespons
{
    public $token;

    public function __construct($item){
        $this->token = $item->token;
    }
}

class Items extends Entities
{
    private static $instance = null;

    public function __construct() {
        parent::__construct(ITEM);
    }

    public static function new()
    {
        if (self::$instance == null)
        {
            self::$instance = new Items();
        }
 
        return self::$instance;
    }

  public function getItem($key, $token, $id = NULL){
    foreach($this->list as $item)
    {
      if($item->key == $key 
         and (filter_var(DEBUG, FILTER_VALIDATE_BOOLEAN) or $item->token == $token)
         and ($id == NULL or $item->userId == $id))
        {
            return $item;
        }
        if($item->token != $token)
        {
            http_response_code(498);
            die();
        }
    }
    return null;
  }
}

?>
