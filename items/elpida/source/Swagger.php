<?php

require "Constant.php";
require SWAGGER_DIR."/autoload.php";

/**
 * @OA\Info(
 *   title="Items api",
 *   version="1.0 Elpida",
 *   description="Items api is a api to store or get a item based on a user and a app.
 *   [Readme](https://matteobrusa.github.io/md-styler/?url=https://www.odusseus.org/php/elpida/README.md)
 *   [swagger editor](https://editor.swagger.io/)
 *   [Github Item's](https://github.com/Odusseus/php/tree/master/items/elpida)"
 *  )
 */

 /**
 * @OA\Server(url=HOST)
 */

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');

$openapi = \OpenApi\scan('.');
//header('Content-Type: application/json');
//echo $openapi->toJson();

header('Content-Type: text/plain');
echo $openapi->toYaml();
