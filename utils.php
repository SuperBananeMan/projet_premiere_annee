<?php

// Fichier pour les fonctions utiles
// à importer dans les autres fichiers
// avec : require('utils.php');
//https://stackoverflow.com/questions/8104998/how-to-call-function-of-one-php-file-from-another-php-file-and-pass-parameters-t

//exemple d'utilisation : $db = getDB();
function getDB() {
    $db = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 'root', '');
    return $db;
}


//fonction qui renvoie un texte entre guillemets simples
function text2quote($text) {
    return "'$text'";
}


?>