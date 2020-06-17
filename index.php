<?php
$home = "home";
if(!is_dir($home)){
    mkdir("home");
}
chdir(getcwd() . DIRECTORY_SEPARATOR . $home);
$url = getcwd();
//echo $url;
$content = scandir($url);
//print_r($content);

$contents = [];
foreach ($content as $item) {
    if ($item !== "." && $item !== "..") {
      echo "<br>".$item ;
      $contents[$item] = $item;
    }
  }

?>