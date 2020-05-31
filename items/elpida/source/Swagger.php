<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require "Constant.php";
require SWAGGER_DIR."/autoload.php";
$openapi = \OpenApi\scan('.');
header('Content-Type: application/x-yaml');
//echo $openapi->toYaml();
echo $openapi->toJson();
