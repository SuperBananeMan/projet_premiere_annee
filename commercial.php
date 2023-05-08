<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    
    <!-- Inclure les bibliothèques jQuery et DataTables -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="src/styleheet">

    <link rel="icon" type="image/x-icon" href="./src/assets/logo-v2.png">

    
    <title>ISA Compta</title>

</head>
<body>
    
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
	

    
    
    
    
    
    ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar_color sticky-top">
        <!-- Container wrapper -->
        <div class="container">
      <!-- Navbar brand -->
            <a class="navbar-brand" href="">
            <img
          src="src/assets/logo-v2.png"
          
          loading="lazy"
          class="mylogo"
            />
            </a>
        

            <!-- Toggle button -->
            <button
                class="navbar-toggler"
                type="button"
                    data-mdb-toggle="collapse"
                    data-mdb-target="#navbarButtonsExample"
                    aria-controls="navbarButtonsExample"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                <i class="fas fa-bars"></i>
            </button>
      
          <!-- Collapsible wrapper -->
          <div class="collapse navbar-collapse " id="navbarButtonsExample">
            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link text-dark leTitre" href="#">ISA Comptable</a>
              </li>
            </ul>
            

            <!-- mid links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav--item-elt-mid justify-content-between">
              <?php
                if ($_USER_ROLE == "Admin"){
                  echo '<li class="nav--item-elt-mid">
				  <input type="button" class="nav--item-elt-mid button-nav" onclick="window.location.href=`index.php`" value="Admin">
                </li>';
                }

                if ($_USER_ROLE == "Commercial" || $_USER_ROLE == "Admin"){
                  echo '<li class="nav--item-elt-mid">
				  <input type="button" class="nav--item-elt-mid button-nav" onclick="window.location.href=`commercial.php`" value="Frais">
                </li>';
                }

                if ($_USER_ROLE == "Comptable" || $_USER_ROLE == "Admin"){
                  echo '<li class="nav--item-elt-mid">
				  <input type="button" class="nav--item-elt-mid button-nav" onclick="window.location.href=`comptable.php`" value="Comptable">
                </li>';
                }

              ?>
              
            </ul>
            
            <!-- Right links -->
        
            <?php

              echo '<div id="user_info" class="d-flex align-items-center ">
              
              '. $_USER_INIT . ' - ' . $_USER_ROLE .''
              .'</div>';
            
             
            
            ?>
              

            
          </div>
                
          <div class="d-flex align-items-center mb-2 mb-lg-0 nav--item-elt-mid">
                <?php
                  $log = "Se déconnecter";
                  if ($_USER_INIT == NULL) {
                    $log = "Se connecter";
                  }
                echo '<button type="button" class="btn button_color  me-2"><a class="text-light text_deco" href="login.php">'.$log.'</a></button>';
                ?>

          </div>
          <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->


          <!-- Main Content For Commercial-->

          <!--Description-->
          <!-- 
            un utilisateur commercial peut créer des factures (fraie) et les envoyer à la base de données pour les faire valider par un comptable
          -->

          <script>let table = new DataTable('#myTable');</script>

        <div class="all_center container myTitreDiv">
          <h1 class="text-center mt-4 myTitre all_center">Mes Frais En Cours</h1>     
        </div> 

    <div class="container">
          <div class="mt-2 pt-5"> <!-- Partie gauche avec le tableau-->
            <table id="myTable">
              <thead>
                <tr>
                  <th>Intitulé</th>
                  <th>Prix</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>User</th>
                  <th>Pièce-Jointe</th>
                  <th>Etat</th>
                  <th>Modifier</th>
                  <th>Supprimer</th>
            
                </tr>
              </thead>
              <tbody>
                <?php
                // Connexion à votre base de données
                $pdo = getDB();                
                // Recupere l'id du Users

               
                $select_opt= NULL;
                if ($_USER_ROLE == "Admin"){
                  $select_opt = "SELECT * FROM fraie WHERE id_paiement = 3" . ";";
                }
                else{
                  $select_opt = "SELECT * FROM fraie WHERE Id_Users = " . $_USER_ID . " AND id_paiement = 3" . ";";
                }
                
                
                // Exécuter une requête pour récupérer les données
                $resultat = $pdo->query($select_opt);
                $res2 = $pdo->query("SELECT * FROM etat ");
                $name = $pdo->query("SELECT * FROM users"); 
                $types = $pdo->query("SELECT * FROM type"); 
                //Array
                $myarray_res = array();
                $myarray_res2 = array();
                $myarray_name = array();
                $myarray_type = array();
                foreach ($resultat as $row) {
                  //push the data in the array
                  array_push($myarray_res, $row);
                  
                }
                

                foreach ($res2 as $row2) {
                  //push the data in the array
                  array_push($myarray_res2, $row2);
                  
                }

                  
                // Boucle pour afficher les résultats de la requête

                foreach ($name as $nom){
                
                  array_push($myarray_name, $nom);
                  

                }
                
                  
                foreach ($types as $type){

                  array_push($myarray_type, $type);
                
                
                }
                
                for ($i=0; $i < count($myarray_res); $i++) {
                  
                  echo "<tr>";
                  echo "<td>" . $myarray_res[$i]['Intitule'] . "</td>";
                  echo "<td>" . $myarray_res[$i]['prix'] . "</td>";
                  
                  
                  foreach ($myarray_type as $type) {
                    if ($myarray_res[$i]['Id_Type'] == $type['Id_Type']){
                      echo "<td>" . $type['Nom'] . "</td>";
                    }
                  }
                  
                  
                  echo "<td>" . $myarray_res[$i]['date_frais'] . "</td>";

                  



                  foreach ($myarray_name as $nom) {
                    if ($myarray_res[$i]['Id_Users'] == $nom['Id_Users']){
                      echo "<td>" . $nom['Nom'] . "</td>"; 
                    }
                  }
                  
                  echo "<td><a href=". $myarray_res[$i]['file_frais'] . "  target='_blank'>Voir</a></td>";



                  //echo "<td>" . $myarray_res2[$i]['type_paiement'] . "</td>";
                  if ($myarray_res[$i]['id_paiement'] == 1) {
                    echo "<td>" . $myarray_res2[0]['type_paiement'] . "</td>";
                  } else if ($myarray_res[$i]['id_paiement'] == 2){
                    echo "<td>" . $myarray_res2[1]['type_paiement'] . "</td>";
                  }
                  else if ($myarray_res[$i]['id_paiement'] == 3){
                    echo "<td>" . $myarray_res2[2]['type_paiement'] . "</td>";
                  }


                    // Vérifier si le formulaire a été soumis, supprime le fraie
                  if(isset($_POST['delete_fraie'])) {
                    $id = $_POST['delete_fraie'];

                    //recupere les infos du frais
                    $stmt = $pdo->prepare("SELECT * FROM fraie WHERE Id_Fraie = :id");
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $file = $row['file_frais'];

                    if ($file != NULL && $file != "" && file_exists($file)) {
                      //supprime le fichier
                      unlink($file);
                    }

                    //supprime le frais
                    // Préparer et exécuter une requête de suppression
                    $stmt = $pdo->prepare("DELETE FROM fraie WHERE Id_Fraie = ?");
                    
                    $stmt->execute([$id]);
                
                    
                  
                    
                    
                    
                  }

                  // Vérifier si le formulaire a été soumis, Modifie le fraie
                  if(isset($_POST['edit_frais'])) {
                    $id = $_POST['edit_frais'];
                    $date = $_POST['date_frais'];
                    $intitule = $_POST['libelle_frais'];
                    $prix = $_POST['prix_frais'];
                    $type = $_POST['type_frais'];
                    $etat = 3; // lorsque le commercial modifie un fraie, il passe TOUJOURS en attente de validation (id_paiement = 3)
                    $file = $_POST['file_frais']; //get the file name from the form
                    $action = $_POST['action_frais'];
                    //get file extension
                    $file_ext = explode('.', $file);
                    $file_ext = strtolower(end($file_ext));

                    //file name adjustment
                    
                    $file = $file . '_' . $id . '.' . $file_ext;
                    


                    //get the id of the user who owns the fraie
                    $id_user = $pdo->query("SELECT Id_Users FROM fraie WHERE Id_Fraie = " . $id . ";");
                    $id_user = $id_user->fetch();
                    $id_user = $id_user['Id_Users'];


                    $target_dir = "uploads/"."$id_user"."/"; //target directory

                    //check if there is already a file in the database for this fraie
                    $file_check = $pdo->query("SELECT file_frais FROM fraie WHERE Id_Fraie = " . $id . ";");
                    $file_check = $file_check->fetch();
                    $file_check = $file_check['file_frais']; //get the file name from the database
                    
                    //if there is already a file in the database for this fraie
                    if ($file_check == $file || $action == "0"){ 
                      //$file_check == $file NEVER TRUE (DOESN'T WORK)
                      //do nothing
                      $file = $file_check;
                      $target_file = $file_check;
                    }
                    else if ($file != NULL && $action == "1"){

                     $file = basename($_FILES["file_frais_fl"]["name"])."_".$id.'.'.$file_ext;
                      

                      if (file_exists($file_check)){
                        //rename the old file
                        rename($file_check, $target_dir . $file);
                      }
                      else {
                        //error
                        //create an alert
                        echo '<script type="text/javascript">alert("Erreur lors de la modification du fichier");</script>';
                      }

                      
                      //upload the new file
                      
                      $target_file = $target_dir . basename($_FILES["file_frais_fl"]["name"])."_".$id.'.'.$file_ext;
                      move_uploaded_file($_FILES["file_frais_fl"]["tmp_name"], $target_file);
                      
                      
                      


                      

                    }
                    else if ($action == "2"){
                      //delete the old file
                      unlink($file_check);
                      //set the file name to empty
                      $target_file = "";
                    }
                    else {
                      //error
                      //create an alert
                      echo '<script type="text/javascript">alert("Erreur lors de la modification du fichier");</script>';
                    }

                    

                    // Préparer et exécuter une requête de modification

                    
                    $stmt = $pdo->prepare("UPDATE fraie SET date_frais = ?, Intitule = ?, prix = ?, Id_Type = ?, id_paiement = ?, file_frais = ?  WHERE Id_Fraie = ?");
                    
                    $stmt->execute([$date, $intitule, $prix, $type, $etat, $target_file, $id]);
                    
                  
                    
                    
                    
                  }


                  // Vérifier si le formulaire a été soumis, Modifie le fraie

                 

                  echo '<td> 
                      <form method="post" action="commercial.php">
                        <input type="hidden" name="modify_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                        <script> const compte_params_'.$myarray_res[$i]['Id_Fraie'].' = []; 
                        //add data to the array
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['date_frais'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['Intitule'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['prix'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['Id_Type'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['file_frais'].'");
                        
                        
                        </script>
                        <button type="button" class="btn btn-primary" onclick="editFrais('.$myarray_res[$i]['Id_Fraie'] .','. text2quote("commercial.php") .','. text2quote($myarray_res[$i]['Intitule']) . ',' . 'compte_params_'.$myarray_res[$i]['Id_Fraie'].')" >
                          Modifier
                        </button>
                      </form>
                    </td>';
                  
                  // Modale de confirmation de suppression
                  echo '<td> 
                  <form method="post" action="commercial.php">
                    <input type="hidden" name="delete_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                    <button type="button" class="btn btn-danger" onclick="deleteFrais('.$myarray_res[$i]['Id_Fraie'] .','. text2quote("commercial.php") .','. text2quote($myarray_res[$i]['Intitule']).')">Supprimer</button>
                  </form>
                </td>';

                  echo "</tr>";



                }
                //echo "################## : ".$myarray_res[0]['file_frais'];

                ?>
              </tbody>
            </table>
              
            <script>


   




              
              $(document).ready(function() {
                $('#myTable').DataTable( {
                  "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
                  }
              } );
              } );
            
            
            </script>
        </div>
    </div>

    <h1 class="text-center mt-4">Frais Accepté</h1>



    <!--Tableau des Fraies payés-->
    <script>table = new DataTable('#myTable_2');</script>

    <div class="container">
          <div class="mt-2 pt-5"> <!-- Partie gauche avec le tableau-->
            <table id="myTable_2">
              <thead>
                <tr>
                  <th>Intitulé</th>
                  <th>Prix</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>User</th>
                  <th>Pièce-Jointe</th>
                  <th>Etat</th>
                  <!--<th>Modifier</th>-->
                  <!--<th>Supprimer</th>-->
                  <?php
                  if ($_USER_ROLE == "Admin"){
                    echo "<th>Modifier</th>";
                    echo "<th>Supprimer</th>";
                  }
                  ?>
            
                </tr>
              </thead>
              <tbody>
                <?php
                // Connexion à votre base de données
                $pdo = getDB();                
                // Recupere l'id du Users

               
                $select_opt= NULL;
                if ($_USER_ROLE == "Admin"){
                  $select_opt = "SELECT * FROM fraie WHERE id_paiement = 2" . ";";
                }
                else{
                  $select_opt = "SELECT * FROM fraie WHERE Id_Users = " . $_USER_ID . " AND id_paiement = 2" . ";";
                }
                
                
                // Exécuter une requête pour récupérer les données
                $resultat = $pdo->query($select_opt);
                $res2 = $pdo->query("SELECT * FROM etat ");
                $name = $pdo->query("SELECT * FROM users"); 
                $types = $pdo->query("SELECT * FROM type"); 
                //Array
                $myarray_res = array();
                $myarray_res2 = array();
                $myarray_name = array();
                $myarray_type = array();
                foreach ($resultat as $row) {
                  //push the data in the array
                  array_push($myarray_res, $row);
                  
                }

                foreach ($res2 as $row2) {
                  //push the data in the array
                  array_push($myarray_res2, $row2);
                  
                }

                  
                // Boucle pour afficher les résultats de la requête

                foreach ($name as $nom){
                
                  array_push($myarray_name, $nom);
                  

                }
                
                  
                foreach ($types as $type){

                  array_push($myarray_type, $type);
                
                
                }
                
                for ($i=0; $i < count($myarray_res); $i++) {
                  
                  echo "<tr>";
                  echo "<td>" . $myarray_res[$i]['Intitule'] . "</td>";
                  echo "<td>" . $myarray_res[$i]['prix'] . "</td>";
                  
                  
                  foreach ($myarray_type as $type) {
                    if ($myarray_res[$i]['Id_Type'] == $type['Id_Type']){
                      echo "<td>" . $type['Nom'] . "</td>";
                    }
                  }
                  
                  
                  echo "<td>" . $myarray_res[$i]['date_frais'] . "</td>";

                  



                  foreach ($myarray_name as $nom) {
                    if ($myarray_res[$i]['Id_Users'] == $nom['Id_Users']){
                      echo "<td>" . $nom['Nom'] . "</td>"; 
                    }
                  }

                  echo "<td><a href=". $myarray_res[$i]['file_frais'] . "  target='_blank'>Voir</a></td>";



                  //echo "<td>" . $myarray_res2[$i]['type_paiement'] . "</td>";
                  if ($myarray_res[$i]['id_paiement'] == 1) {
                    echo "<td>" . $myarray_res2[0]['type_paiement'] . "</td>";
                  } else if ($myarray_res[$i]['id_paiement'] == 2){
                    echo "<td>" . $myarray_res2[1]['type_paiement'] . "</td>";
                  }
                  else if ($myarray_res[$i]['id_paiement'] == 3){
                    echo "<td>" . $myarray_res2[2]['type_paiement'] . "</td>";
                  }


                    // Vérifier si le formulaire a été soumis, supprime le fraie
                  /*if(isset($_POST['delete_fraie'])) {
                    $id = $_POST['delete_fraie'];
                  
                    // Préparer et exécuter une requête de suppression
                    $stmt = $pdo->prepare("DELETE FROM fraie WHERE Id_Fraie = ?");
                    
                    $stmt->execute([$id]);
                
                    
                  
                    
                    
                    
                  }*/

                  // Vérifier si le formulaire a été soumis, Modifie le fraie
                  /*if(isset($_POST['edit_frais'])) {
                    $id = $_POST['edit_frais'];
                    $date = $_POST['date_frais'];
                    $intitule = $_POST['libelle_frais'];
                    $prix = $_POST['prix_frais'];
                    $type = $_POST['type_frais'];
                    

                    // Préparer et exécuter une requête de modification
                    
                    $stmt = $pdo->prepare("UPDATE fraie SET date_frais = ?, Intitule = ?, prix = ?, Id_Type = ? WHERE Id_Fraie = ?");
                    
                    $stmt->execute([$date, $intitule, $prix, $type, $id]);
                    
                  
                    
                    
                    
                  }*/


                  // Vérifier si le formulaire a été soumis, Modifie le fraie

                 
                  if ($_USER_ROLE == "Admin"){
                    
                    echo '<td> 
                      <form method="post" action="commercial.php">
                        <input type="hidden" name="modify_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                        <script> const compte_params_'.$myarray_res[$i]['Id_Fraie'].' = []; 
                        //add data to the array
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['date_frais'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['Intitule'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['prix'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['Id_Type'].'");
                        
                        </script>
                        <button type="button" class="btn btn-primary" onclick="editFrais('.$myarray_res[$i]['Id_Fraie'] .','. text2quote("commercial.php") .','. text2quote($myarray_res[$i]['Intitule']) . ',' . 'compte_params_'.$myarray_res[$i]['Id_Fraie'].')" >
                          Modifier
                        </button>
                      </form>
                    </td>';
                  
                  // Modale de confirmation de suppression
                  echo '<td> 
                  <form method="post" action="commercial.php">
                    <input type="hidden" name="delete_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                    <button type="button" class="btn btn-danger" onclick="deleteFrais('.$myarray_res[$i]['Id_Fraie'] .','. text2quote("commercial.php") .','. text2quote($myarray_res[$i]['Intitule']) . ')">Supprimer</button>
                  </form>
                </td>';
                  }
                  

                  echo "</tr>";



                }
                ?>
              </tbody>
            </table>
              
            <script>


   




              
              $(document).ready(function() {
                $('#myTable_2').DataTable( {
                  "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
                  }
              } );
              } );
            
            
            </script>
        </div>
    </div>


    <h1 class="text-center mt-4">Frais Refusé</h1>



    <!--Tableau des Fraies payés-->
    <script>table = new DataTable('#myTable_3');</script>

    <div class="container">
          <div class="mt-2 pt-5"> <!-- Partie gauche avec le tableau-->
            <table id="myTable_3">
              <thead>
                <tr>
                  <th>Intitulé</th>
                  <th>Prix</th>
                  <th>Type</th>
                  <th>Date</th>
                  <th>Utilisateur</th>
                  <th>Pièce-Jointe</th>
                  <th>Etat</th>
                  <!--<th>Modifier</th>-->
                  <!--<th>Supprimer</th>-->
                  <?php
                  if ($_USER_ROLE == "Admin"){
                    echo "<th>Modifier</th>";
                    echo "<th>Supprimer</th>";
                  }
                  ?>
            
                </tr>
              </thead>
              <tbody>
                <?php
                // Connexion à votre base de données
                $pdo = getDB();                
                // Recupere l'id du Users

               
                $select_opt= NULL;
                if ($_USER_ROLE == "Admin"){
                  $select_opt = "SELECT * FROM fraie WHERE id_paiement = 1" . ";";
                }
                else{
                  $select_opt = "SELECT * FROM fraie WHERE Id_Users = " . $_USER_ID . " AND id_paiement = 1" . ";";
                }
                
                
                // Exécuter une requête pour récupérer les données
                $resultat = $pdo->query($select_opt);
                $res2 = $pdo->query("SELECT * FROM etat ");
                $name = $pdo->query("SELECT * FROM users"); 
                $types = $pdo->query("SELECT * FROM type"); 
                //Array
                $myarray_res = array();
                $myarray_res2 = array();
                $myarray_name = array();
                $myarray_type = array();
                foreach ($resultat as $row) {
                  //push the data in the array
                  array_push($myarray_res, $row);
                  
                }

                foreach ($res2 as $row2) {
                  //push the data in the array
                  array_push($myarray_res2, $row2);
                  
                }

                  
                // Boucle pour afficher les résultats de la requête

                foreach ($name as $nom){
                
                  array_push($myarray_name, $nom);
                  

                }
                
                  
                foreach ($types as $type){

                  array_push($myarray_type, $type);
                
                
                }
                
                for ($i=0; $i < count($myarray_res); $i++) {
                  
                  echo "<tr>";
                  echo "<td>" . $myarray_res[$i]['Intitule'] . "</td>";
                  echo "<td>" . $myarray_res[$i]['prix'] . "</td>";
                  
                  
                  foreach ($myarray_type as $type) {
                    if ($myarray_res[$i]['Id_Type'] == $type['Id_Type']){
                      echo "<td>" . $type['Nom'] . "</td>";
                    }
                  }
                  
                  
                  echo "<td>" . $myarray_res[$i]['date_frais'] . "</td>";

                  



                  foreach ($myarray_name as $nom) {
                    if ($myarray_res[$i]['Id_Users'] == $nom['Id_Users']){
                      echo "<td>" . $nom['Nom'] . "</td>"; 
                    }
                  }


                  echo "<td><a href=". $myarray_res[$i]['file_frais'] . "  target='_blank'>Voir</a></td>";


                  //echo "<td>" . $myarray_res2[$i]['type_paiement'] . "</td>";
                  if ($myarray_res[$i]['id_paiement'] == 1) {
                    echo "<td>" . $myarray_res2[0]['type_paiement'] . "</td>";
                  } else if ($myarray_res[$i]['id_paiement'] == 2){
                    echo "<td>" . $myarray_res2[1]['type_paiement'] . "</td>";
                  }
                  else if ($myarray_res[$i]['id_paiement'] == 3){
                    echo "<td>" . $myarray_res2[2]['type_paiement'] . "</td>";
                  }


                    // Vérifier si le formulaire a été soumis, supprime le fraie
                  /*if(isset($_POST['delete_fraie'])) {
                    $id = $_POST['delete_fraie'];
                  
                    // Préparer et exécuter une requête de suppression
                    $stmt = $pdo->prepare("DELETE FROM fraie WHERE Id_Fraie = ?");
                    
                    $stmt->execute([$id]);
                
                    
                  
                    
                    
                    
                  }*/

                  // Vérifier si le formulaire a été soumis, Modifie le fraie
                  /*if(isset($_POST['edit_frais'])) {
                    $id = $_POST['edit_frais'];
                    $date = $_POST['date_frais'];
                    $intitule = $_POST['libelle_frais'];
                    $prix = $_POST['prix_frais'];
                    $type = $_POST['type_frais'];
                    

                    // Préparer et exécuter une requête de modification
                    
                    $stmt = $pdo->prepare("UPDATE fraie SET date_frais = ?, Intitule = ?, prix = ?, Id_Type = ? WHERE Id_Fraie = ?");
                    
                    $stmt->execute([$date, $intitule, $prix, $type, $id]);
                    
                  
                    
                    
                    
                  }*/


                  // Vérifier si le formulaire a été soumis, Modifie le fraie

                 
                  if ($_USER_ROLE == "Admin"){
                    
                    echo '<td> 
                      <form method="post" action="commercial.php">
                        <input type="hidden" name="modify_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                        <script> const compte_params_'.$myarray_res[$i]['Id_Fraie'].' = []; 
                        //add data to the array
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['date_frais'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['Intitule'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['prix'].'");
                        compte_params_'.$myarray_res[$i]['Id_Fraie'].'.push("'.$myarray_res[$i]['Id_Type'].'");
                        
                        </script>
                        <button type="button" class="btn btn-primary" onclick="editFrais('.$myarray_res[$i]['Id_Fraie'] .','. text2quote("commercial.php") .','. text2quote($myarray_res[$i]['Intitule']) . ',' . 'compte_params_'.$myarray_res[$i]['Id_Fraie'].')" >
                          Modifier
                        </button>
                      </form>
                    </td>';
                  
                  // Modale de confirmation de suppression
                  echo '<td> 
                  <form method="post" action="commercial.php">
                    <input type="hidden" name="delete_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                    <button type="button" class="btn btn-danger" onclick="deleteFrais('.$myarray_res[$i]['Id_Fraie'] .','. text2quote("commercial.php") .','. text2quote($myarray_res[$i]['Intitule']) .')">Supprimer</button>
                  </form>
                </td>';
                  }
                  

                  echo "</tr>";



                }
                ?>
              </tbody>
            </table>
              
            <script>


   




              
              $(document).ready(function() {
                $('#myTable_3').DataTable( {
                  "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
                  }
              } );
              } );
            
            
            </script>
        </div>
    </div>


    <!-- Ajouter Fraies -->


    <p class="h2 text-center mt-5 mb-5">Ajouter un Frais</p>

          <form action="commercial.php" class="container" method="POST">


          <div class="row mt-2 container">
            <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" placeholder="Intitulé" class="form-control" name="intitulé" required>
                  </div>
                  <div class="col-md-6">
                    <input type="date" placeholder="14/03/2023" class="form-control" name="date" required>
                  </div>
            </div>
            <div class="row">

              <div class="col-md-6 mt-2">
                <input type="number" placeholder="Prix" class="form-control" name="prix" required>
              </div>
              
              <?php
                  // Connexion à la base de données
                  $mysqli = getDB_mysqli();
            
                  // Vérifier la connexion
                  if (mysqli_connect_errno()) {
                      echo "Échec de la connexion à la base de données: " . mysqli_connect_error();
                      exit();
                  }
                
                  // Exécuter une requête pour récupérer les types de dépenses
                  $result = mysqli_query($mysqli, "SELECT Id_Type, Nom FROM type");
                
                  // Vérifier si la requête a réussi
                  if (!$result) {
                      echo "Échec de la requête: " . mysqli_error($mysqli);
                      exit();
                  }
                
                  // Parcourir les résultats et afficher les options dans le formulaire
                  $options = "";
                  while ($row = mysqli_fetch_assoc($result)) {
                      $options .= "<option value='" . $row['Id_Type'] . "'>" . $row['Nom'] . "</option>";
                  }
                
                  // Fermer la connexion à la base de données
                  mysqli_close($mysqli);
                  ?>

                <!-- Afficher le formulaire HTML avec les options dynamiques -->
                <!--type de dépense-->
                <div class="form-group col-md-6 mt-2">
                    <select class="form-control" name="type" id="type">
                        <?php echo $options; ?>
                    </select>
                </div>

                <div class="form-group col-md-12 mt-2">
                  <input type="file" placeholder="Fichier" class="form-control" name="file">
                </div>
              
             <?php

            $mysqli = getDB_mysqli();
            $resultU = mysqli_query($mysqli, "SELECT Id_Users, Nom FROM users");

             // Vérifier la connexion
             if (mysqli_connect_errno()) {
              echo "Échec de la connexion à la base de données: " . mysqli_connect_error();
              exit();
            }

            $options2 = "";
                  while ($row = mysqli_fetch_assoc($resultU)) {
                    if ($row['Id_Users'] == $_USER_ID){
                      $options2 .= "<option value='" . $row['Id_Users'] . "' selected>" . $row['Nom'] . " (" . $row['Id_Users'] . ")" . "</option>";
                    }
                    else{
                      $options2 .= "<option value='" . $row['Id_Users'] . "'>" . $row['Nom'] . " (" . $row['Id_Users'] . ")" . "</option>";
                    }
            }

            
            //si le rôle de l'user actuel est 1 (admin) alors on affiche les options pour choisir l'utilisateur
            if ($_USER_ROLE == "Admin"){
              echo '
              <div class="form-group col-md-6 mt-3 text-center">
                <label for="U">Utilisateur ID :</label>
              </div>
              <div class="form-group col-md-6 mt-2">
                
                <select class="form-control" name="user" id="U">

                  '. $options2 .'
                
                </select>

              </div>
              
              ';
            }
            mysqli_close($mysqli);


            ?>

            </div>
            <!--<p class="text-center mt-5"><button type="submit" class="btn btn-primary" name="delete-user">Ajouter</button></p>-->
            <p class="text-center mt-5"><button type="button" class="btn btn-primary" onclick="addFrais('commercial.php')">Ajouter</button></p>
        </form>
           </div>
          </div>


          <?php
            if (isset($_POST['add_frais'])){
              //check_ini("add.ini");

            }


            if (isset($_POST['libelle_frais']) && isset($_POST['add_frais'])) {
            
                // Connexion à la base de données
                $pdo = getDB();            
                // Récupération des données du formulaire
                $intitule = $_POST['libelle_frais'];
                $date = $_POST['date_frais'];
                $type = $_POST['type_frais'];
                $prix = $_POST['prix_frais'];
                if ($_USER_ROLE == "Admin") $user = $_POST['user'];
                else $user = $_USER_ID;
                $file_name = $_POST['n_file'];

                if ($file_name != ""){

                
                /*START save file in folder*/
                $target_dir = "uploads/".$user."/"; //folder : uploads/user_id/

                // Check if directory exists
                if (!file_exists($target_dir)) {
                  mkdir($target_dir, 0777, true); //create folder : uploads/user_id/; 0777 = full access; true = recursive
                }

                $target_file = $target_dir . basename($_FILES["file"]["name"]); //folder + file name : uploads/user_id/file_name
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                //check_ini($target_file);
               
                // Check if file already exists
                if (file_exists($target_file)) {
                  echo "Sorry, file already exists.";
                  check_ini("err.ini");
                  $uploadOk = 0;
                }

                // Check file size : 1Mo max
                if ($_FILES["file"]["size"] > 1000000) {
                  echo "Sorry, your file is too large.";
                  //check_ini("err.ini");
                  $uploadOk = 0;
                }
                // Allow certain file formats : PNG, JPG, JPEG, GIF, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, CSV
                if($imageFileType != "png" && $imageFileType != "jpg" && $imageFileType != "jpeg"
                && $imageFileType != "gif" && $imageFileType != "pdf" && $imageFileType != "doc"
                && $imageFileType != "docx" && $imageFileType != "xls" && $imageFileType != "xlsx"
                && $imageFileType != "ppt" && $imageFileType != "pptx" && $imageFileType != "txt"
                && $imageFileType != "csv") {
                  echo "Sorry, only PNG, JPG, JPEG, GIF, PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT & CSV files are allowed.";
                  $uploadOk = 0;
                }
                //$uploadOk = 1;
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                  echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                  if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
                  } else {
                    echo "Sorry, there was an error uploading your file.";
                    //check_ini("err.ini");
                  }
                }


                

                
                /*END save file in folder*/
                  
                  }
               

                //check_ini("err.ini");



                
                


                // Préparation et exécution de la requête SQL pour l'insertion des données
                $stmt = $pdo->prepare('INSERT INTO fraie (Intitule, prix, date_frais, id_paiement, Id_Type, Id_Users, file_frais) VALUES (:intitule, :prix, :dateok, "3", :typeok, :iduser, :fileok)');
                
                $stmt->bindParam(':intitule', $intitule);
                $stmt->bindParam(':prix', $prix);
						    $stmt->bindParam(':dateok', $date);
						    $stmt->bindParam(':typeok', $type);
                $stmt->bindParam(':iduser', $user);
                $stmt->bindParam(':fileok', $target_file);
                

						    $stmt->execute();

                if ($file_name != ""){
                  $stmt = $pdo->prepare('SELECT Id_fraie FROM fraie WHERE file_frais = :fileok');
                  $stmt->bindParam(':fileok', $target_file);
                  $stmt->execute();
                  $row = $stmt->fetch(PDO::FETCH_ASSOC);
                  $id_frais = $row['Id_fraie'];
                  
                  //rename file
                  $new_file_name = $target_file.'_'.$id_frais.'.'.$imageFileType;
                  rename($target_file, $new_file_name);
                  //update file name in DB
                  $stmt = $pdo->prepare('UPDATE fraie SET file_frais = :fileok WHERE Id_fraie = :id_frais');
                  $stmt->bindParam(':fileok', $new_file_name);
                  $stmt->bindParam(':id_frais', $id_frais);
                  $stmt->execute();


                  
                }
              
                // Affichage d'un message de succès
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					  <strong>C est nickel</strong> l ajout est OK.
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>';
              
              //refresh la page js
              /*
              echo '<script type="text/javascript">
              setTimeout(function(){window.location = "commercial.php"}, 2000);
              </script>';
              */

            }
            ?>

            <?php
            if (isset($_POST['greating'])) {
              $data = $_POST['greating'];
              echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>'.$data.'</strong> l ajout est OK.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
            }
            ?>





<script src="./utils.js"></script>
</body>
</html>