<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "UserActivateLogic.php";

header('Access-Control-Allow-Origin: *');

$userActivateLogic = new UserActivateLogic();
$httpResponse = $userActivateLogic->isIpCheck();

if ($httpResponse->code != HttpCode::OK) {
 Common::exit($httpResponse);
}

if (isset($_GET[ISALIVE])) {
 $httpResponse = $userActivateLogic->getIsAlive();
 Common::exit($httpResponse);
}

$appname = empty($_COOKIE[APPNAME]) ? "" : $_COOKIE[APPNAME];
$nickname = empty($_COOKIE[NICKNAME]) ? "" : $_COOKIE[NICKNAME];
$activationCode = empty($_COOKIE[ACTIVATION_CODE]) ? "" : $_COOKIE[ACTIVATION_CODE];

$httpResponse = $userActivateLogic->activeUser($appname, $nickname, $activationCode);
Common::exit($httpResponse);
