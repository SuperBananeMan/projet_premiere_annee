<?php
// Fichier pour les mise à jour de la base de données (temporaire)

// fonction pour verifier les actions déjà effectuées à l'aide d'un fichier ini
//création du fichier ini si il n'existe pas

//require('utils.php');

function check_ini($file){
    if (!file_exists($file)) {
        $ini = fopen($file, "w");
        fclose($ini);
    }
    else{
        return true;
    }
}



//fonction pour verrifier si une action existe dans le fichier ini
function check_action_ini($file,$action){
    $ini = fopen($file, "r");
    while (!feof($ini)) {
        $line = fgets($ini);
        $line = explode("=", $line);
        if ($line[0] == $action) {
            return true; //si l'action existe, on retourne true
        }
    }
    return false; //si l'action n'existe pas, on retourne false
}

//fonction pour ajouter une action dans le fichier ini (si elle n'a pas déjà été effectuée, ou qu'elle n'est pas déjà présente)
function add_ini($file,$action,$state){
    if (!check_action_ini($file,$action)) {
        $ini = fopen($file, "a");
        fwrite($ini, $action."=".$state."\n");
        fclose($ini);

    }
}

//fonction pour verifier si une action a déjà été effectuée en retournant un booléen
function check_action($file,$action,$state){
    $ini = fopen($file, "r");
    while (!feof($ini)) {
        $line = fgets($ini);
        $line = explode("=", $line);
        if ($line[0] == $action) {
            if ($line[1] == $state) {
                return true; //si l'action existe et a été effectuée, on retourne true
            }
            else{
                return false; //si l'action existe mais n'a pas été effectuée, on retourne false
            }
        }
    }
    fclose($ini);
    echo "action non trouvée";
    return false; //si l'action n'existe pas, on retourne false
}

//changer état d'une action dans le fichier ini
function change_sate($file,$action,$state){
    $ini = fopen($file, "r");
    $lines = array();
    while (!feof($ini)) {
        $line = fgets($ini);
        $line = explode("=", $line);
        if ($line[0] == $action) {
            $line[1] = $state;
        }
        $line = implode("=", $line);
        array_push($lines, $line);
    }
    fclose($ini);
    $ini = fopen($file, "w");
    foreach ($lines as $line) {
        fwrite($ini, $line."\n");
    }
    fclose($ini);





}





//fonction pour changer le mot de passe de tous les utilisateurs en sha256
function bdd_upd_password(){
    //on vérifie si l'action existe dans le fichier ini
    if (!check_action_ini("bdd_upd.ini","HASH_PASSWORD")) {
        //si elle n'existe pas, on l'ajoute
        add_ini("bdd_upd.ini","HASH_PASSWORD","0");
    }

    //on vérifie dans la base de données si la taille maximale des mots de passe est de 64 caractères
    $bdd = getDB();
    $req = $bdd->prepare('SELECT MAX(LENGTH(Passwrd)) FROM users');
    $req->execute();
    $data = $req->fetch();
    $req->closeCursor();
    if ($data[0] != 64) {
        //si la taille maximale n'est pas de 64 caractères, on la définie à 64
        $bdd = getDB();
        $req = $bdd->prepare('ALTER TABLE users MODIFY Passwrd VARCHAR(64) NOT NULL');
        $req->execute();
        $req->closeCursor();

        echo "<br>taille maximale des mots de passe définie à 64 caractères <br>";
    }
    else{
        //echo "taille maximale des mots de passe déjà de 64 caractères <br>";
        
    }

    //on vérifie si l'action a déjà été effectuée
    if (!check_action("bdd_upd.ini","HASH_PASSWORD","1")) {
        //si elle n'a pas été effectuée, on l'effectue
        echo "encodage des mots de passe en cours... <br>";
        $bdd = getDB();
        $req = $bdd->prepare('SELECT * FROM users');
        $req->execute();
        while ($data = $req->fetch()) {
            $password = hash_password_rpd($data['Passwrd'], get_salt());
            $req2 = $bdd->prepare('UPDATE users SET Passwrd = :password WHERE Id_Users = :id');
            $req2->execute(array(
                'password' => $password,
                'id' => $data['Id_Users']
            ));
        }
        $req->closeCursor();
        //on change l'état de l'action dans le fichier ini
        change_sate("bdd_upd.ini","HASH_PASSWORD","1");
        echo "<br>encodage des mots de passe terminé <br>";




    }
    else{
        //echo "action déjà effectuée";
    }
}

//fonction pour corriger les erreurs de saut de ligne dans le fichier ini
function fix_ini(){
    //on parcourt le fichier ini et on limite les sauts de ligne à 2 entre chaque action
    $ini = fopen("bdd_upd.ini", "r");
    $lines = array();
    while (!feof($ini)) {
        $line = fgets($ini);
        if ($line != "\n") {
            array_push($lines, $line);
        }
    }
    fclose($ini);
    $ini = fopen("bdd_upd.ini", "w");
    foreach ($lines as $line) {
        fwrite($ini, $line);
    }
    fclose($ini);

}



//fonction pour mettre à jour la base de données
function bdd_upd_main(){
    
    check_ini("bdd_upd.ini");

    $ex = "EXEMPLE";

    //on vérifie si l'action existe dans le fichier ini
    if (!check_action_ini("bdd_upd.ini",$ex)) {
        //si elle n'existe pas, on l'ajoute
        add_ini("bdd_upd.ini",$ex,"0");
    }

    //on vérifie si l'action a déjà été effectuée
    if (!check_action("bdd_upd.ini",$ex,"1")) {
        //si elle n'a pas été effectuée, on l'effectue
        echo "action effectuée<br>";
        //on change l'état de l'action dans le fichier ini
        change_sate("bdd_upd.ini",$ex,"1");
    }
    else{
        //echo "action déjà effectuée<br>";
    }

    echo "<br>";

    //on vérifie si l'action a déjà été effectuée
    if (!check_action("bdd_upd.ini",$ex,"1")) {
        //si elle n'a pas été effectuée, on l'effectue
        echo "action effectuée<br>";
        //on change l'état de l'action dans le fichier ini
        change_sate("bdd_upd.ini",$ex,"1");
    }
    else{
        //echo "action déjà effectuée<br>";
    }



    bdd_upd_password();

    fix_ini();




    


}




