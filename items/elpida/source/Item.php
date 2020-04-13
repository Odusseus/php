<?php namespace Elpida;

require_once "Constant.php";
require_once "Common.php";

class Item
{
 public $key,
  $value;

 // Multi constructor
 // https://stackoverflow.com/questions/1699796/best-way-to-do-multiple-constructors-in-php
 public function __construct()
 {
  // allocate your stuff
 }

 public static function set($key, $value)
 {
  $instance = new self();
  $instance->key = $key;
  $instance->value = $value;
  $instance->save();
  return $instance;
 }

 public static function get($key)
 {
  $instance = new self();
  $instance->key = $key;
  $instance->load();
  return $instance;
 }

 public function delete(){
  if(file_exists($this->getFilename()))
  {
      unlink($this->getFilename());
  }
  $this->key = null;
  $this->value = null;
}

 public function getFilename()
 {
  return $filename = DATA_DIR . "/" . VALUE_DIR . "/{$this->key}.txt";
 }

 public function save()
 {
  $filename = $this->getFilename();
  $file = fopen($filename, "wb") or die("Unable to open file!");
  fwrite($file, $this->value);
  fclose($file);
 }

 public function load()
 {
  $filename = $this->getFilename();
  if (file_exists($filename)) {
   if (filesize($filename) > 0) {
    $file = fopen($filename, "rb");
    $this->value = fread($file, filesize($filename));
    fclose($file);
   } else {
    $this->value = "";
   }
  } else {
   $this->value = "";
   $this->save();
  }
 }

 public function getJsonGetRespons()
 {
  $itemEntity = new ItemEntity($this->value);
  return json_encode($itemEntity, JSON_FORCE_OBJECT);
 }

 function isset() {
  if (isset($this->value)) {
   return true;
  }
  return false;
 }
}

class ItemEntity
{
 public $value;

 public function __construct($value)
 {
  $this->value = $value;
 }
}
