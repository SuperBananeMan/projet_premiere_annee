
<?php

session_start();
        require('utils.php');
        require('BDD_updater.php');
        $_USER_INIT= NULL;
        $_USER_ROLE= NULL;
        $_USER_ID= NULL;
        if (isset($_SESSION['user'])) {
            $_USER_INIT = $_SESSION['user'];
            $_USER_ROLE = $_SESSION['role_u'];
            $_USER_ID = $_SESSION['id_u'];
        }
        //en tant qu'exemple
        if ($_USER_INIT != NULL) {
            switch ($_USER_ROLE) {
                case 'Admin':
                    
                    break;
                case 'Comptable':
                    
                    break;
                case 'Commercial':
                    
                    break;
                default:
                    echo "Error user role 01";
                    break;
            }
			      if ($_USER_ROLE != "Commercial")
            {
              if ($_USER_ROLE == "Admin"){
              }
              else{
                header("location:403.html");
              }
            
			      }
        } else {
            header("location:login.php");
        }


        //on récupère les données GET
        $id_frais = $_GET['id'];
        $pdo = getDB();   //connexion à la base de donnée   

        //on récupère les données du frais
        $stmt = $pdo->prepare("SELECT * FROM fraie WHERE Id_fraie = ?");
        $stmt->execute([$id_frais]);
        $frais = $stmt->fetch();

        //si l'utilisateur n'est pas un admin
        if ($_USER_ROLE != "Admin") {
            //on compare l'id de l'utilisateur qui a créé le frais et l'id de l'utilisateur connecté
            if ($frais['Id_Users'] == $_USER_ID) {
                //on télécharge le fichier
                $file = $frais['file_frais'];
                if (file_exists($file)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
                    header('Content-Transfer-Encoding: binary');
                    header('Expires: 0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));

                    ob_clean();
                    flush();
                    readfile($file);
                    exit;
                }
                else {
                    echo "Error file not found";
                }
            } else {
                header("location:../403.html");
            }
        }
        else if ($_USER_ROLE == "Admin") {
            //on télécharge le fichier
            $file = $frais['file_frais'];
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($file) . '"');
                header('Content-Transfer-Encoding: binary');
                header('Expires: 0');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));

                ob_clean();
                flush();
                readfile($file);
                exit;
            }
            else {
                echo "Error file not found";
            }
        }


        ?>