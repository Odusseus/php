<?php
  require_once("constant.php");
  require_once("item.php");

  header('Access-Control-Allow-Origin: *');

  $key = "";
  $code = "";

  if(isset($_GET[KEY])){
    $key = $_GET[KEY];
  }

  if(isset($_GET[CODE])){
    $code = $_GET[CODE];
  }

  if (empty($key) or empty($code)){
    echo <<<EOT
    Bacon ipsum dolor amet fatback capicola andouille buffalo, leberkas flank picanha turducken alcatra jerky shoulder strip steak. Hamburger picanha ham hock beef ribs boudin ball tip. Venison kielbasa kevin sirloin prosciutto shankle tenderloin. Picanha ham hock leberkas burgdoggen doner hamburger filet mignon brisket ham porchetta swine boudin salami t-bone beef. Pork chop beef ball tip shank salami pastrami turkey. Landjaeger tail sirloin chicken, corned beef jowl alcatra pork belly beef meatloaf brisket shank burgdoggen leberkas. Rump t-bone sausage kielbasa flank cow short ribs spare ribs shankle.
    EOT;
  }

  $items = new Items();
  echo $items->getItem($key, $code);
  
?>