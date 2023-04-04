<?php

// Fichier pour les fonctions utiles
// à importer dans les autres fichiers
// avec : require('utils.php');
//https://stackoverflow.com/questions/8104998/how-to-call-function-of-one-php-file-from-another-php-file-and-pass-parameters-t

//exemple d'utilisation : $pdo = getDB();
function getDB() {
    $pdo = new PDO('mysql:host=localhost;dbname=projet_1erannee;charset=utf8', 'root', '');
    //**********
    return $pdo;
}
function getDB_mysqli() {
    //**********
    $mysqli = mysqli_connect("localhost", "root", "", "projet_1erannee");

    return $mysqli;
}


//fonction qui renvoie un texte entre guillemets simples
function text2quote($text) {
    return "'$text'";
}


?>