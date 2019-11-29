<?php

require_once("constant.php");
require_once("common.php");

date_default_timezone_set('Europe/Amsterdam');

class Score {

    public $name,
           $score,
           $country,
           $token,
           $timestamp,
           $ip;

    function __construct($score, $name, $country, $token){
        $this->score = intval($score);
        $this->name = htmlspecialchars($name);
        $this->country = ($country);
        $this->token = htmlspecialchars($token);
        $this->timestamp = date("d-m-Y H:i:s");
        $this->ip = get_client_ip();
    }
}

class Scores {

    public 
        $list = [],
        $filename = SCOREFILENAME;
    
    function __construct(){
        if(file_exists($this->filename)){
            $str = file_get_contents($this->filename);
            $this->list = json_decode($str);
        }
    }

    public function cut($max){

        if($max > count($this->list)){
            return;
        }

        array_multisort( array_column($this->list, "score"), SORT_DESC,$this->list); 
        
        $newList = [];

        for ($i = 0; $i < $max; $i++) {
            $newList[] = $this->list[$i];
        } 
        $this->list = $newList;
    }

    public function getJson(){
        return json_encode($this->list);
    }

    public function save() {
        $this->cut(MAXHIGGSCORES);
        $str = json_encode($this->list);
        $myfile = fopen($this->filename, "w") or die("Unable to open file!");
        fwrite($myfile, $str);
        fclose($myfile);
    }

    public function delete(){
        //unlink($this->filename);
    }

    public function push($score){
        $this->list[] = $score;
    }

    // TODO testing
    public function pushFirst($score){
        $newList[] = $score;
        foreach ($this->list as $row => $value) {
            $newList[] = $value;
        }
        
        $this->list = $newList;
    }

    public function getHighestScore(){
        $highScore = null;

        if(count($this->list) > 0){
            $highScore = $this->list[0];
        };
        
        return $highScore;
    }

    public function getList(){
        return $this->list;
    }

    public function getSortList(){
        array_multisort( array_column($this->list, "score"), SORT_DESC,$this->list); 
        return $this->list;
    }

    public function getToken($score){
        $highestScore = 0;
        if(!is_null($this->getHighestScore())){
            $highestScore = $this->getHighestScore()->score;
        }
        
        
        $date = new DateTime(); 
        
        $year = $date->format("Y");
        $days = $date->format("z");
        $hours = $date->format("H");
        
        $token = hash("md5", $year + $days + $hours + $score + $highestScore);
        return $token;
    }

    public function sortByScore($a, $b) {
        if ($a->score == $b->score) { return 0; }
        return ($a->score < $b->score) ? -1 : 1;
        // if ($a["Score"]["score"] == $b["Score"]["score"]) { return 0; }
        // return ($a["Score"]["score"]<$b["Score"]["score"])?-1:1;
        // if ($a["score"] == $b["score"]) { return 0; }
        // return ($a["score"]<$b["score"])?-1:1;
    }

    public function sortList(){
        usort($this->list, array($this, "sortByScore"));
    }
}

class ScoreShort {
    
        public $score,
               $name,
               $country,
               $timestamp;
       
        function __construct($score){
            $this->score = $score->score;
            $this->name = $score->name;
            $this->country = $score->country;
            $this->timestamp = $score->timestamp;
        }
    }

class ScoreShorts {
        
            public $list = [],
                   $token = 0;

            function __construct($scores, $token){
                $this->token = $token;
                foreach( $scores->list as $score){
                    $newScoreShort = new ScoreShort($score);
                    $this->push($newScoreShort);
                 }
            }

            public function getList(){
                return $this->list;
            }
            public function getJsonList(){
                $this->getSortList();
                $scoreResponse = new ScoreResponse();
                $scoreResponse->list = $this->list;
                $scoreResponse->token = $this->token;
                return json_encode($scoreResponse);
            }

            public function push($scoreShort){
                $this->list[] = $scoreShort;
            }

            public function getSortList(){
                array_multisort( array_column($this->list, "score"), SORT_DESC,$this->list); 
                return $this->list;
            }
        
            public function sortByScore($a, $b) {
                if ($a->score == $b->score) { return 0; }
                return ($a->score < $b->score) ? -1 : 1;
            }
        
            public function sortList(){
                usort($this->list, array($this, "sortByScore"));
            }
        }

class ScoreResponse {
    public $list = [],
           $token;
}

?>