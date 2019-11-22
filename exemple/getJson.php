<?php
    
    header('Access-Control-Allow-Origin: *');

    include "score.php";

    $score = 0;

    if (isset($_GET["score"])){
        $score = (int)$_GET["score"];
    }

    $scores = new Scores();
    $token = null;
    
    if ($score != 0 
        && (is_null($scores->getHighestScore()) 
        || $scores->getHighestScore()->score < $score)){
        $token = $scores->getToken($score);
    }

    $scoreShorts = new ScoreShorts($scores, $token);

    echo $scoreShorts->getJsonList();

 ?>

