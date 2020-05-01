<?php namespace Items;

require_once "Constant.php";
require_once "Common.php";
require_once "ItemSetLogic.php";

header('Access-Control-Allow-Origin: *');

$itemSetogic = new ItemSetLogic();

if (isset($_GET[ISALIVE])) {
 $httpResponse = $itemSetogic->getIsAlive();
 Common::exit($httpResponse);
}

$cookie = empty($_COOKIE[COOKIE]) ? "" : $_COOKIE[COOKIE];

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

$httpResponse = $itemSetogic->setItem($cookie, $content);
Common::exit($httpResponse);