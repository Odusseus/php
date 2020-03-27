<?php namespace Elpida;

function getJsonValue($decoded, $valueName){
  if(isset($decoded[$valueName]))
  {
    return $decoded[$valueName];
  }
  return null;
}

// https://stackoverflow.com/questions/15699101/get-the-client-ip-address-using-php
function get_client_ip() {
  $ipaddress = '';
  if (getenv('HTTP_CLIENT_IP'))
      $ipaddress = getenv('HTTP_CLIENT_IP');
  else if(getenv('HTTP_X_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
  else if(getenv('HTTP_X_FORWARDED'))
      $ipaddress = getenv('HTTP_X_FORWARDED');
  else if(getenv('HTTP_FORWARDED_FOR'))
      $ipaddress = getenv('HTTP_FORWARDED_FOR');
  else if(getenv('HTTP_FORWARDED'))
     $ipaddress = getenv('HTTP_FORWARDED');
  else if(getenv('REMOTE_ADDR'))
      $ipaddress = getenv('REMOTE_ADDR');
  else
      $ipaddress = 'UNKNOWN';
  return $ipaddress;
}

// https://www.php.net/manual/en/function.com-create-guid.php
function GUID()
{
  if (function_exists('com_create_guid') === true)
  {
      return trim(com_create_guid(), '{}');
  }

  return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

?>