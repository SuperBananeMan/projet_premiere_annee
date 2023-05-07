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

//fonction pour hasher un mot de passe avec un salt grâce à la fonction hash_hmac
function hash_password_rpd($password,$salt){
    if ($salt == false) {
        echo "<br>salt non trouvé<br>";
        return false;
    }
    $password = hash_hmac('sha256', $password, $salt);
    return $password;

}

//get the salt from the ini file
function get_salt(){
    $ini = fopen("bdd.ini", "r");
    while (!feof($ini)) {
        $line = fgets($ini);
        $line = explode("=", $line);
        if ($line[0] == "SALT") {
            return $line[1]; //si le salt existe, on retourne le salt
        }
    }
    return false; //si le salt n'existe pas, on retourne false
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


?>