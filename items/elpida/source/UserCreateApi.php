<?php namespace Items;

require_once "enum/HttpCode.php";
require_once "UserCreateLogic.php";

/**
 * @OA\Get(
 *     path="/php/elpida/UserCreateApi.php/isalive",
 *     summary="is Api alive?",
 *     @OA\Parameter(
 *       name="isalive",
 *       @OA\Schema(type="string"),
 *       in="query",
 *       description="Check if the methode is alive when string is available in the query.",
 *       required=false 
 *       ),
 *     @OA\Response(
 *       response="200",
 *       description="When is alive.",
 *       @OA\Schema(
 *         @OA\Property(
 *             property="code",
 *             type="number",
 *             description="Http status code.",
 *               @OA\Property(
 *                   property="message",
 *                   type="string",
 *                   description="The message."
 *               ),
 *               example={
 *                 "code": 200,
 *                 "message": "true"
 *               }
 *         )
 *       )
 *    )
 * )
 */

/**
 * @OA\Post(
 *     path="/php/elpida/UserCreateApi.php",
 *     summary="Create a account for a user and a app.",
 *     description="Call UserCreateApi with the parameters below to create a account. A email will be send to validate the account",
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

header('Access-Control-Allow-Origin: *');

$userCreateLogic = new UserCreateLogic();

$httpResponse = $userCreateLogic->isIpCheck();

if ($httpResponse->statusCode != HttpCode::OK) {
 Common::exit($httpResponse);
}

if (isset($_GET[ISALIVE])) {
 $httpResponse = $userCreateLogic->getIsAlive();
 Common::exit($httpResponse);
}

$httpResponse = $userCreateLogic->isIdMaxCheck();
if ($httpResponse->statusCode != HttpCode::OK) {
 Common::exit($httpResponse);
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

$httpResponse = $userCreateLogic->createUser($content);
Common::exit($httpResponse);
