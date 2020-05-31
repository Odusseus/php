<?php namespace Items;

/**
 * @OA\Info(
 *   title="Items api",
 *   version="1.0",
 *   description="Api to store and get a item for a user and a app.",
 *    )
 */

/**
 * @OA\Get(
 *     path="/php/elpida/UserCreateApi.php?isalive",
 *     @OA\Response(
 *       response="200",
 *       description="When is alive.")
 * )
 */

/**
 * @OA\Post(
 *     path="/php/elpida/UserCreateApi.php",
 *     summary="Create a account for a user and a app.",
 *     description="Create a account and send a validation mail.",
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
 *         description="Success when account is created."
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="FORBIDDEN when Ip is blacklisted or when User already exists.."
 *     ),
 *     @OA\Response(
 *         response=423,
 *         description="LOCKED when Maximum users is reached."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="NOT_FOUND when APPNAME is  not found."
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="UNPROCESSABLE_ENTITY when NICKNAME/PASSWORD/EMAIL/APPNAME is missing."
 *     ),
 * )
 */

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

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
