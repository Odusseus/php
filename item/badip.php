<?php

require_once("constant.php");
require_once("common.php");
require_once("ip.php");

date_default_timezone_set('Europe/Amsterdam');

class BadIps {
    public 
        $list = [],
        $filename = "json/badipList.json"   ;

    function __construct(){
        if(file_exists($this->filename)){
            $str = file_get_contents($this->filename);
            $this->list = json_decode($str);
        }
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

    public function add($ip){
        $this->list[] = $ip;
    }

    public function isBadIp($ip){
        
        if(is_null($ip) or is_null($this->list)){
            return false;
        }

        foreach($this->list as $item)
        {
          if($item->ip == $ip->ip){
              return true;
          }
        }        
        return false;
    }
}

?>