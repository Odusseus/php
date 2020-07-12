<?php namespace Items;

/**
 * @OA\Get(
 *     path="/php/elpida/ItemSetApi.php/isalive",
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
 *     path="/php/elpida/ItemSetApi.php",
 *     summary="Save a item.",
 *     description="Save a item based on the authorisation cookie.",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(
 *                     property="value",
 *                     type="string",
 *                     description="The value of the item."
 *                 ),
 *                 @OA\Property(
 *                     property="version",
 *                     type="number",
 *                     description="The version of the item. The new version must always be higher than the saved version."
 *                 ),
 *                 example={ 
*	                   "value":"demo value...",
*	                   "version": 2
*                  }
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Success when item is saved."
 *     ),
 *      @OA\Response(
 *         response=400,
 *         description="BAD_REQUEST when version of the item is obsolete."
 *     ),
 *     @OA\Response(
 *         response=403,
 *         description="FORBIDDEN when Ip is blacklisted or when User already exists.."
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="NOT_FOUND when COOKIE/USER/VALUE is not found."
 *     ),
 *     @OA\Response(
 *         response=406,
 *         description="NOT_ACCEPTABLE when Item is to long."
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="UNPROCESSABLE_ENTITY when COOKIE/VALUE is missing."
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="INTERNAL_SERVER_ERROR when Item is not saved."
 *     ),
 * )
 */

require_once "Constant.php";
require_once "Common.php";
require_once "ItemSetLogic.php";

header('Access-Control-Allow-Origin: *');

$itemSetogic = new ItemSetLogic();
$httpResponse = $itemSetogic->isIpCheck();

if ($httpResponse->statusCode != HttpCode::OK) {
  Common::exit($httpResponse);
 }

if (isset($_GET[IS_ALIVE])) {
 $httpResponse = $itemSetogic->getIsAlive();
 Common::exit($httpResponse);
}

$cookie = empty($_COOKIE[COOKIE]) ? "" : $_COOKIE[COOKIE];

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

$httpResponse = $itemSetogic->setItem($cookie, $content);
Common::exit($httpResponse);