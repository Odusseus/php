<?php namespace Items;

/**
 * @OA\Get(
 *     path="/php/elpida/UserLoginApi.php/isalive",
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
 *       description="When is alive.")
 * )
 */

/**
 * @OA\Post(
 *     path="/php/elpida/UserLoginApi.php",
 *     summary="User log in for a app and get a authorisation cookie.",
 *     description="User log in for a app.",
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
 *                 example={
 *                   "appname": "myApp",
 *                   "nickname": "myNickname",
 *                   "password": "myPassword",
*                 }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success when user is log in. He gets a authorisation cookie"
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="FORBIDDEN when Ip is blacklisted or when User already exists.."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="NOT_FOUND when APPNAME/NICKNAME/PASSWORD or the combination appname and nickname are not found."
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="UNPROCESSABLE_ENTITY when APPNAME/NICKNAME/PASSWORD is missing."
 *     ),
 * )
 */

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "UserLoginLogic.php";

//header('Access-Control-Allow-Origin: *');

$userLoginLogic = new UserLoginLogic();
$httpResponse = $userLoginLogic->isIpCheck();

if ($httpResponse->statusCode != HttpCode::OK) {
 Common::exit($httpResponse);
}

if (isset($_GET[ISALIVE])) {
 $httpResponse = $userLoginLogic->getIsAlive();
 Common::exit($httpResponse);
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

$httpResponse = $userLoginLogic->loginUser($content);
Common::exit($httpResponse);
