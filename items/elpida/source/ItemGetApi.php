<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "ItemGetLogic.php";
require_once "Common.php";

header('Access-Control-Allow-Origin: *');

$itemGetLogic = new ItemGetLogic();

if (isset($_GET[ISALIVE])) {
 $httpResponse = $itemGetLogic->isAlive();
 Common::exit($httpResponse);
}

if (isset($_GET[MAX_LENGTH])) {
 $httpResponse = $itemGetLogic->getMaxLength();
 Common::exit($httpResponse);
}

$cookie = empty($_COOKIE[COOKIE]) ? "" : $_COOKIE[COOKIE];
$httpResponse = $itemGetLogic->getItem($cookie);

if ($httpResponse->code != HttpCode::OK) {
 Common::exit($httpResponse);
}

if (isset($_GET[ITEMLENGTH])) {
 $httpResponse = $itemGetLogic->getLength($httpResponse->message);
}

Common::exit($httpResponse);