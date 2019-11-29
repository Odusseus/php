<?php
    header('Access-Control-Allow-Origin: *');
    
    require_once("common.php");
    require_once("constant.php");
    require_once("ip.php");
    include "badip.php";
    include "score.php";

    $badIps = new BadIps();
    $ipnr = get_client_ip();
    if($badIps->isBadIp($ipnr)){
        exit("Bad ip ".$ipnr);
    }

    $scores = new Scores();

    if(  isset($_POST["name"]) and isset($_POST["score"]) and isset($_POST["country"]) and isset($_POST["token"])) {

        $score = new Score($_POST["score"], $_POST["name"], $_POST["country"], $_POST["token"]);

        $controleToken = $scores->getToken($score->score);
        if($controleToken != $score->token){
            $ip = new Ip(TYPEREQUESTHIGHSCORE,"Bad token");
            $badIps->push($ip);
            $badIps->save();
            exit("Bad token ".$ipnr);
        }

        if(is_null($scores->getHighestScore()) || $score->score > $scores->getHighestScore()->score){
            $scores->pushFirst($score);
            $scores->save();
        }
    }
 ?>

