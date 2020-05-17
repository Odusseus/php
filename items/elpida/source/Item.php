<?php namespace Items;

require_once "enum/Error.php";
require_once "Common.php";
require_once "Constant.php";
require_once "ItemEntity.php";

class Item
{
 public $key,
        $itemEntity;

 // Multi constructor
 // https://stackoverflow.com/questions/1699796/best-way-to-do-multiple-constructors-in-php
 public function __construct()
 {
  // allocate your stuff
 }

 public static function set($key, $value, $version)
 {
  $instance = new self();
  $instance->key = $key;
  $instance->itemEntity = new ItemEntity($value, $version);
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

 public function delete()
 {
  if (file_exists($this->getFilename())) {
   unlink($this->getFilename());
  }
  $this->key = null;
  $this->itemEntity = null;
 }

 public function getFilename()
 {
  return DATA_DIR . "/" . VALUE_DIR . "/{$this->key}.json";
 }

 public function save()
 {
  if (Common::isNullOrEmptyString($this->key)) {
   error_log(Error::EmptyValue . " Item->save(), \$key", 0);
   return;
  }

  $filename = $this->getFilename();  
  $json = json_encode($this->itemEntity, JSON_FORCE_OBJECT);
  file_put_contents($filename, $json, LOCK_EX);  
 }

 public function load()
 {
  $filename = $this->getFilename();
  if (file_exists($filename)) {
    $json = file_get_contents($filename);
    $itemEntity = json_decode($json);
    $this->itemEntity = $itemEntity;
  }
 }

 public function getJsonGetRespons()
 {
  return json_encode($this->itemEntity, JSON_FORCE_OBJECT);
 }

 function isSet() {
  if (isset($this->itemEntity)) {
   return true;
  }
  return false;
 }
}
