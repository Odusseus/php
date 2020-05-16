<?php namespace Items;

date_default_timezone_set('Europe/Amsterdam');

class Entity
{

 public $id,
 $key,
  $timestamp;

 public function __construct($key)
 {
  $this->key = $key;
  $this->timestamp = date("d-m-Y H:i:s");
 }

 public function set($data)
 {
  foreach ($data as $key => $value) {
   $this->{$key} = $value;
  }

 }
}
