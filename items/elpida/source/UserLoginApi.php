<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "UserLoginLogic.php";

header('Access-Control-Allow-Origin: *');

$userLoginLogic = new UserLoginLogic();
$httpResponse = $userLoginLogic->isIpCheck();

if ($httpResponse->code != HttpCode::OK) {
 Common::exit($httpResponse);
}

if (isset($_GET[ISALIVE])) {
 $httpResponse = $userLoginLogic->getIsAlive();
 Common::exit($httpResponse);
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

$userLoginLogic->loginUser($content);

//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);
Common::exit($httpResponse);
