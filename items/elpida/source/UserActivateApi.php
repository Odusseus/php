<?php namespace Items;

require_once("enum/HttpCode.php");
require_once("Constant.php");
require_once("UserActivateLogic.php");

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

$appname = empty($_GET[APPNAME]) ? "" : $_GET[APPNAME];
$nickname = empty($_GET[NICKNAME]) ? "" : $_GET[NICKNAME];
$activationCode = empty($_GET[ACTIVATION_CODE]) ? "" : $_GET[ACTIVATION_CODE];

$httpResponse = $userActivateLogic->activeUser($appname, $nickname, $activationCode);
Common::exit($httpResponse);
