# Tutoriel : explorateur de fichiers en php

## Comment afficher le contenu d'un répertoire ?
### Comment récuperer l'url du current work directory ?
Je commence par ouvrir une balise dans index.php
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


