<?php namespace Items;

/**
 * @OA\Get(
 *     path="/php/elpida/UserActivateApi.php/isalive",
 *     summary="is Api alive?",
 *     @OA\Parameter(
 *       name="isalive",
 *       @OA\Schema(type="string"),
 *       in="query",
 *       description="Check is the methode is alive when string is available in the query.",
 *       required=false 
 *       ),
 *     @OA\Response(response="200", description="When is alive.")
 * )
 */

/**
 * @OA\Post(
 *     path="/php/elpida/UserActivateApi.php",
 *     summary="Activate a account",
 *     description="Call UserActivateApi with the parameters below to activate the account.",
 *     @OA\Parameter(
 *       name="nickname",
 *       in="query",
 *       description="Nickname of the user.",
 *        required=true,
 *        @OA\Schema(
 *          type="string",
 *         )
 *       ),
 *       @OA\Parameter(
 *       name="activationcode",
 *       in="query",
 *       description="The email activationcode.",
 *        required=true,
 *        @OA\Schema(
 *          type="number",
 *        )
 *      ),
 *      @OA\Parameter(
 *       name="appname",
 *       in="query",
 *       description="The name of the app.",
 *        required=true,
 *        @OA\Schema(
 *          type="string",
 *        )
 *      ),
 *     @OA\Response(
 *       response="200",
 *       description="When account is activated."
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="FORBIDDEN when Ip is blacklisted or when User already exists.."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="NOT_FOUND when NICKNAME/APPNAME/ACTIVATION_CODE is  not found."
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="UNPROCESSABLE_ENTITY when NICKNAME/APPNAME/ACTIVATION_CODE is missing."
 *     )
 * )
 */

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

$appname = empty($_GET[APPNAME]) ? "" : $_GET[APPNAME];
$nickname = empty($_GET[NICKNAME]) ? "" : $_GET[NICKNAME];
$activationCode = empty($_GET[ACTIVATION_CODE]) ? "" : $_GET[ACTIVATION_CODE];

$httpResponse = $userActivateLogic->activeUser($appname, $nickname, $activationCode);
Common::exit($httpResponse);
