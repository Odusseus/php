<?php namespace Items;

/**
 * @OA\Get(
 *     path="/php/elpida/UserCreateApi.php?isalive",
 *     @OA\Response(response="200", description="When is alive.")
 * )
 */

/**
 * @OA\Post(
 *     path="/php/elpida/UserCreateApi.php",
 *     summary="Create a new account for a user and a app.",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="appname",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="nickname",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string"
 *                 ),
 *                 example={
 *                   "appname": "myApp",
 *                   "nickname": "myNickname",
 *                   "password": "myPassword",
 *                   "email": "my@email.org"
*                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
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
