<?php
require "/Swagger/vendor/autoload.php";
$openapi = \OpenApi\scan('.');
header('Content-Type: application/x-yaml');
echo $openapi->toYaml();
