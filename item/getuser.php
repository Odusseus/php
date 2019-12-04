<?php
  require_once("constant.php");
  require_once("item.php");
  require_once("user.php");

  header('Access-Control-Allow-Origin: *');

  $user = "";

  if(isset($_GET[USER])){
    $user = $_GET[USER];
    $users = new Users();
    $id = $users->getKey($user);
    if($id)
    {
      exit("Ok");
    }
    else
    {
      exit("No user.");
    }
  }
  else
  {
    exit("No user.");
  }

  exit ($itemGetRespons);
  
?>