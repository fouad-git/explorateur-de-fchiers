<?php
$url = getcwd();
//echo $url;
$content = scandir($url);
print_r($content);
foreach($content as $item){
    echo "<br>" . $item;
}
?>