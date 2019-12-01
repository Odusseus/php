<?php
require_once("constant.php");
require_once("common.php");
require_once("entity.php");

class Item extends Entity{
    
    public $token,
           $userId;
   
    function __construct($key, $token, $userKey){
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
        $users = new Users();
        $user = $users->getKey($userKey);
        
        $this->userId = $user->id;
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
        $file = fopen($filename, "rb") or die("Unable to open file!");
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
        // TODO update and save
        //$this->token = GUID();
        $itemGetRespons = new ItemGetRespons($this);
        return json_encode($itemGetRespons);
    }
}

class ItemPostRespons {
    
    public $key,
           $token;

    function __construct($item){
        $this->key = $item->key;
        $this->token = $item->token;
    }
}

class ItemGetRespons {
    
    public $key,
           $token,
           $value;

    function __construct($item){
        $this->key = $item->key;
        $this->token = $item->token;
        $this->value = $item->getValue();
    }
}

class Items extends Entities {

    function __construct() {
        parent::__construct(ITEM);
    }

  public function getItem($key, $token){
    foreach($this->list as $item)
    {
      if($item->key == $key and $item->token == $token){
        return $item;
        }
    }
    return "No items";
  }
}

?>
