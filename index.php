<?php
$home = "accueil";
if(!is_dir($home)){
    mkdir("accueil");
}

if(!isset($_POST['cwd'])){
   $url = getcwd() . DIRECTORY_SEPARATOR . $home;  
}
else{
    $url = $_POST['cwd'];
}
chdir($url );
$content = scandir($url);
//print_r($content);
$path = "";
$breadcrumbs = explode(DIRECTORY_SEPARATOR,$url);
  echo "<form method='post' id='ch_cwd'>"; 

foreach($breadcrumbs as $item){
          $path .= $item.DIRECTORY_SEPARATOR;
          if(strstr($path, $home)){
            echo "<button type='submit' value='".substr
            ($path,0,-1)."' name='cwd'>";//substr retourne une partie d'une chaîne,ici le 1er et le dernier de $path.
            echo $item; 
            echo "</button>";
          }   
    }
    echo "</form>";
foreach ($content as $item) {
    if ($item !== "." && $item !== "..") {
            echo "<br><button type='submit' form='ch_cwd' value='".$url.DIRECTORY_SEPARATOR.$item."' name='cwd'>";
            echo $item ;
            echo "</button>";
     // $contents[$item] = $item;
    }
  }
 
?>