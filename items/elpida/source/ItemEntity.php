<?php namespace Items;

class ItemEntity
{
 public $value,
        $version;

 public function __construct($value, $version)
 {
  $this->value = $value;
  $this->version = $version;
 }
}
