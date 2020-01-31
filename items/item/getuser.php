<?php
  //ini_set('display_errors', 1);

  require_once("constant.php");
  require_once("item.php");
  require_once("user.php");

  if(isset($_GET[ISALIVE]) and filter_var($_GET[ISALIVE], FILTER_VALIDATE_BOOLEAN))
  {
      exit(TRUETEXT);
  }

  $user = "";
  if(isset($_GET[USER])){
    $user = $_GET[USER];
    $users = Users::new();
    $id = $users->getKey($user);
    if($id)
    {
      exit("Ok");
    }
    else
    {
      http_response_code(404);
      exit("user [".$user."] not found.");
    }
  }
  else
  {
    http_response_code(404);
    exit("No user.");
  }

  exit ($itemGetRespons);  
  
?>