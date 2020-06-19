# Tutoriel : explorateur de fichiers en php

## Comment afficher le contenu d'un répertoire ?
### Comment récuperer l'url du current work directory ?
Je commence par ouvrir une balise dans ```index.php```.
J'ai d'abord besoin de récupérer l'url du dossier de travail courant (current work directory). J'utilise pour cela la fonction ```getcwd()``` et je fais un ```echo``` pour afficher le résultat : 
```
<?php
$url = getcwd();
echo $url;
?>
```
### Comment afficher le contenu d'un dossier ?
J'affiche maintenant les dossiers contenus dans le répertoire en utilisant la fonction ```scandir()```, je lui passe en paramétre la variable ``` $url```. La fonction ```scandir()``` liste les fichiers et dossiers qui sont contenus dans un dossier,   et qui retourne un tableau de fichier et dossier. Comme c'est un tableau (array) on ne pas l'afficher avec  ```echo```, on va regardé son contenu avec ```print_r()```. On met le résultat de ```scandir()``` dans une variable, par exemple ```$content```, et on passe cette variable en paramétre à la fonction ```print_r()``` : 
```
$content = scandir($url);
print_r($content);
```
La fonction ```print_r()```, quand on lui passe une variable qui contient un tableau en paramétre,  retourne un format permettant de voir les clés et les éléments.
### Comment afficher uniquement les éléments contenus dans le dossier ?
Pour afficher les éléments du tableau contenu dans la variable ```$content```, on utilise la structure de contrôle ```foreach()```. C'est une boucle qui fait une itération pour chaque élément du tableau. On lui passe en paramétre la variable qui contient le tableau suivi du mot clé ```as```, puis d'une nouvelle variable qui va contenir un élément à chaque itération de la boucle :
``` 
foreach($content as $item){
    echo "<br>" . $item;
}
```
## Comment créer le dossier courant qui sera le point de départ de notre programme ?
Le script ne doit surtout pas ouvrir le répertoire qui le contient (pour d'évidentes raisons de sécurité). Il ouvrira un sous-dossier q'on appelera ```accueil``` : le programme ne pourra remonter dans les parents de ce dossier. On commence donc par vérifier si le dossier ```accueil``` existe dans le répertoire de travail courant. S'il n'existe pas, le programme le crée : 
 ```
 $home = "accueil";
if(!is_dir($home)){
    mkdir("accueil");
} 
```
On place ce code avant le  ```scandir() ```, sinon le programme affichera le contenu du répertoire avant la création du dossier  ```accueil ```. Dans la condition ```if()```, on passe en paramétre la fonction```is_dir()```, précédée de l'opérateur de négation```!```, et dans la fonction ```is_dir```, on passe en paramétre la variable```$home```. ```is_dir```, permet de vérifier que ce qui lui est passé en paramétre est un dossier, donc précédé de l'opérateur de négation il vérifie s'il n'y a pas de dossier qui s'appelle ```accueil```, s'il n'y en a pas, il le crée avec la fonction ```mkdir``` qui signifie **make directory**. 
### Comment ouvrir par défaut le répertoire home ?
Nous allons demander au programme d'ouvrir par défaut le dossier ```accueil```, pour cela on va utiliser la fonction ```chdir()```, qui change le dossier courant.
 ```
 chdir(getcwd() . DIRECTORY_SEPARATOR . $home);
 ```
On utilise la constante prédifinie  ``` DIRECTORY_SEPARATOR ```, pour génerer des slashs ou des anti-slashs en fonction de l'OS où s'éxecute le script. On utilise l'opérateur logique  ```. ``` pour concaténer la fonction  ```getcwd() ```, le  ``` DIRECTORY_SEPARATOR ``` et la variable dans le paramétre de la fonction  ```chdir() ```.
## Comment faire en sorte que .. et . n’apparaissent pas  ?

On commence par déclarer une variable que l'on nomme ```$contents``` et qui va contenir un tableau vide :
    
```$contents = [];```

Dans le foreach, on créé une condition qui vérifie que les valeurs de $item sont différentes de "." et ".." qui correspondent au dossier "racine" et au dossier "parent". Ces deux objets familier aux utilisateurs de système d'exploitation de type UNIX ne nous sont pas utiles et gênent la lisibilité du résultat du foreach. La condition sera toujours vérifiée puisque ces deux objets se retrouveront dans tous les répertoires lorsque l'on naviguera par la suite dans l'arborescence d'où la nécessité de les faire disparaître. De plus, ".." permet de remonter en amont du répertoire "home". Dans la condition, on fait apparaître chaque occurence de $item et on rempli le tableau contenu dans $content avec les $item en remplaçant chaque index du tableau par le nom du fichier correspondant :
```
foreach ($content as $item) {
  if ($item !== "." && $item !== "..") {
    echo "<br>" . $item ;
    $contents[$item] = $item;
  }
}
```
On remplace le ```foreach ($content as $item)``` par cette nouvelle version de la boucle.
## Comment afficher le fil d'ariane (breadcrumbs) ?
Pour faire apparaître l'arborescence sous forme de fil d'ariane, on va scinder en éléments d'un tableau la chaîne de caractéres contenu dans la variable ``` $url```, grace à la fonction ```explode()```. On passe en paramétre de cette fonction ``` DIRECTORY_SEPARATOR ```qui va constituer l'élément qui permet à la fonction de savoir quand elle doit scinder la chaîne de caractére. On place le retour de la fonction dans une variable qu'on va appeler ```$breadcrumbs``` : 
```
$breadcrumbs = explode(DIRECTORY_SEPARATOR,$url);
```
Ensuite on fait apparaître tous les éléments dans une boucle ```foreach()``` :
```
    foreach($breadcrumbs as $item){
        echo "<button>" . $item . "</button>";
    }
```
### Comment naviguer dans l'arborescence via le fil d'ariane ?
On va faire en sorte que chaque élément dans le fil d'ariane soit un bouton cliquable de **type submit** contenu dans un formulaire. Lorsqu'on clique dessus on envoit une donné via la variable ```$_POST```, qu'on va récupérer dans la variale ```$url``` qu'on passera ensuite en paramétre à notre fonction ```chdir()```.
On commence par déclarer une variable ```$path```, qui va nous servir à enregistrer le chemin des dossiers qu'on parcourt dans le fil d'ariane(ce chemin se contruit au fur et à mesure qu'on navigue dans les dossiers). On place cette variable avant la boucle ```foreach()``` qui sert à parcourir la variable```$breadcrumbs```. Autour de la boucle ```foreach()```, on va générer une balise ouvrante et fermante de formulaire. Ce ```<form>``` aura la méthode ```post```.
 Ensuite dans le ```foreach()```, on va concaténer à cette variable ```$path```, les éléments de la variable ```$breadcrumbs```, séparés par des ``` DIRECTORY_SEPARATOR ``` : 
```
$path = "";
$breadcrumbs = explode(DIRECTORY_SEPARATOR,$url);
  echo "<form method='post'>";  
foreach($breadcrumbs as $item){
        $path .= $item.DIRECTORY_SEPARATOR;
        echo "<button type='submit' value='".substr($path,0,-1)."' name='cwd'>";
        echo $item; 
        echo "</button>";

    }
echo "</form>";
```
Concernant la fonction ```substr()```,elle permet de retirer le dernier ``` DIRECTORY_SEPARATOR ``` dans la variable```$path```.
Grace à ce formulaire on va transmettre le nom du dossier dans lequel on veut se positionner : ```$_POST ``` récupére la valeur de la variable ```$path``` du ```<button>``` qui a le name ```cwd```. Lorsque qu'on clique sur un bouton le ```submit``` raffraîchit la page, il nous reste à vérifier qu'il y a quelque chose dans la variable superglobale ```$_POST```, s'il n'y a rien on affecte à ```$url``` le paramétre de ```chdir()``` qu'on utilisait jusqu'à présent. S'il y a quelque chose dans ```$_POST```, on l'affecte à ```$url```. Il nous reste à passer ```$url``` dans le paramétre de la fonction ```chdir()``` : 
```
if(!isset($_POST['cwd'])){
   $url = getcwd() . DIRECTORY_SEPARATOR . $home;  
}
else{
    $url = $_POST['cwd'];
}
chdir($url );
``` 
On place tous ça aprés le ```mkdir()``` et avant le ```scandir()```.


### Comment bloquer la navigation au dossier accueil ?
Dans la boucle ```foreach()``` qui permet d'afficher le fil d'ariane, aprés l'affectation du chemin dans la variable ```$path```, on crée une condition qui vérifie le retour de la fonction ```strstr()```. Cette fonction permet de retourner la premiére occurence d'une chaîne de caractére. On lui pass en paramétre la chaîne de caractére contenu dans ```$path``` et en deuxiéme paramétre la chaîne de caractére contenu dans ```$home``` afin que le retour correspond à ```$home``` :
```
foreach($breadcrumbs as $item){
          $path .= $item.DIRECTORY_SEPARATOR;
          if(strstr($path, $home)){
            echo "<button type='submit' value='".substr
            ($path,0,-1)."' name='cwd'>";//substr retourne une partie d'une chaîne,ici le 1er et le dernier de $path.
            echo $item; 
            echo "</button>";
          }   
    }
```