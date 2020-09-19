<?php namespace Items;

/**
 * @OA\Get(
 *   path="/php/elpida/ItemGetApi.php/isalive",
 *   summary="is Api alive?",
 *   @OA\Parameter(
 *     name="isalive",
 *     @OA\Schema(type="string"),
 *     in="query",
 *     description="Check if the methode is alive when string is available in the query.",
 *     required=false 
 *     ),
 *   @OA\Response(
 *     response="200",
 *     description="When is alive.")
 * )
 */

 /**
 * @OA\Get(
 *   path="/php/elpida/ItemGetApi.php/maxlength",
 *   summary="return the maxlength allowed in bytes of a item?",
 *   @OA\Parameter(
 *     name="maxlength",
 *     @OA\Schema(type="string"),
 *     in="query",
 *     description="Return the maxlength of a item when string is available in the query.",
 *     required=false 
 *     ),
 *   @OA\Response(
 *     response="200",
 *     description="the maxlength of a item in bytes.")
 *  )
 */

 /**
 * @OA\Get(
 *   path="/php/elpida/ItemGetApi.php/itemlength",
 *   summary="return the length (bytes and %) of the saved item.",
 *   @OA\Parameter(
 *     name="itemlength",
 *     @OA\Schema(type="string"),
 *     in="query",
 *     description="Return the length of the saved item when string is available in the query.",
 *     required=false 
 *     ),
 *   @OA\Response(
 *     response="200",
 *     description="the length (bytes and %) of the saved item.")
 * )
 */

/**
 * @OA\Get(
 *   path="/php/elpida/ItemGetApi.php",
 *   summary="Get a item.",
 *   description="Get a saved item based on the authorisation cookie.",
 *   @OA\Response(
 *     response=200,
 *     description="return the item.",
 *     @OA\Schema(
 *       @OA\Property(
 *           property="value",
 *           type="string",
 *           description="The value of the Item to save"
 *       ),
 *       @OA\Property(
 *           property="version",
 *           type="number",
 *           description="The version of the item. The new version must always be higher than the saved version."
 *       ),
 *       example={ 
*	         "value":"demo value...",
*	         "version": 2
*        }
 *     )
 *   )
 * )
 */

require_once "enum/HttpCode.php";
require_once "Constant.php";
require_once "ItemGetLogic.php";
require_once "Common.php";

header('Access-Control-Allow-Origin: *');

$itemGetLogic = new ItemGetLogic();

$httpResponse = $itemGetLogic->isIpCheck();

if ($httpResponse->statusCode != HttpCode::OK) {
 Common::exit($httpResponse);
}

if (isset($_GET[IS_ALIVE])) {
 $httpResponse = $itemGetLogic->getIsAlive();
 Common::exit($httpResponse);
}

if (isset($_GET[MAX_LENGTH])) {
  $httpResponse = $itemGetLogic->getMaxLength();
  Common::exit($httpResponse);
 }

$cookie = empty($_COOKIE[COOKIE_TOKEN]) ? "" : $_COOKIE[COOKIE_TOKEN];
if(empty($cookie)){
  $cookie = $_GET[COOKIE_TOKEN];
}
$httpResponse = $itemGetLogic->getItem($cookie);

if ($httpResponse->statusCode != HttpCode::OK) {
  Common::exit($httpResponse);
}

  if (isset($_GET[ITEMLENGTH])) {
 $httpResponse = $itemGetLogic->getLength($httpResponse->message);
}

Common::exit($httpResponse);
