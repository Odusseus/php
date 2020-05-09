<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "UserCreateLogic.php";

header('Access-Control-Allow-Origin: *');

$userCreateLogic = new UserCreateLogic();

$httpResponse = $userCreateLogic->isIpCheck();

if ($httpResponse->code != HttpCode::OK) {
 Common::exit($httpResponse);
}

if (isset($_GET[ISALIVE])) {
 $httpResponse = $userCreateLogic->getIsAlive();
 Common::exit($httpResponse);
}

$httpResponse = $userCreateLogic->isIdMaxCheck();
if ($httpResponse->code != HttpCode::OK) {
 Common::exit($httpResponse);
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

$httpResponse = $userCreateLogic->createUser($content);
Common::exit($httpResponse);
