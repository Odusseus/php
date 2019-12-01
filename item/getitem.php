<?php
  require_once("constant.php");
  require_once("item.php");
  require_once("user.php");

  header('Access-Control-Allow-Origin: *');

  $key = "";
  $token = "";

  if(isset($_GET[KEY])){
    $key = $_GET[KEY];
  }

  if(isset($_GET[TOKEN])){
    $token = $_GET[TOKEN];
  }

  if (empty($key) or empty($token)){
    exit (<<<EOT
    Bacon ipsum dolor amet fatback capicola andouille buffalo, leberkas flank picanha turducken alcatra jerky shoulder strip steak. Hamburger picanha ham hock beef ribs boudin ball tip. Venison kielbasa kevin sirloin prosciutto shankle tenderloin. Picanha ham hock leberkas burgdoggen doner hamburger filet mignon brisket ham porchetta swine boudin salami t-bone beef. Pork chop beef ball tip shank salami pastrami turkey. Landjaeger tail sirloin chicken, corned beef jowl alcatra pork belly beef meatloaf brisket shank burgdoggen leberkas. Rump t-bone sausage kielbasa flank cow short ribs spare ribs shankle.
    EOT);
  }

  $items = new Items();
  $element = $items->getItem($key, $token);
  
  $users = new Users();
  $user = $users->getId($element->userId);
  $item = new Item($key, $token, $user->key);
  $itemGetRespons = $item->getJsonGetRespons();
  
  exit ($itemGetRespons);
  
?>