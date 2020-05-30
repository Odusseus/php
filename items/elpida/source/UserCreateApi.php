<?php namespace Items;

/**
 * @OA\Get(
 *     path="/php/elpida/UserCreateApi.php?isalive",
 *     @OA\Response(response="200", description="When is alive.")
 * )
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
