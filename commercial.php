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
                <a class="nav-link text-dark " href="#">ISA Comptable</a>
              </li>
            </ul>
            

            <!-- mid links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav--item-elt-mid justify-content-between">
              <?php
                if ($_USER_ROLE == "Admin"){
                  echo '<li class="nav--item-elt-mid">
                  <a class="text-dark my_mid_lnk nav--item-elt-mid" href="index.php">Admin</a>
                </li>';
                }

                if ($_USER_ROLE == "Commercial" || $_USER_ROLE == "Admin"){
                  echo '<li class="nav--item-elt-mid">
                  <a class="text-dark my_mid_lnk nav--item-elt-mid" href="commercial.php">Frais</a>
                </li>';
                }

                if ($_USER_ROLE == "Comptable" || $_USER_ROLE == "Admin"){
                  echo '<li class="nav--item-elt-mid">
                  <a class="text-dark my_mid_lnk nav--item-elt-mid" href="comptable.php">Comptable</a>
                </li>';
                }

              ?>
              
            </ul>
            
            <!-- Right links -->
        
            <?php

              echo '<div class="d-flex align-items-center ">
              
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
          <h1 class="text-center mt-4 myTitre all_center">Mes Fraies</h1>     
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
                  <th>Etat</th>
                  <th>Modifier</th>
                  <th>Supprimer</th>
            
                </tr>
              </thead>
              <tbody>
                <?php
                // Connexion à votre base de données
                $pdo = new PDO("mysql:host=localhost;dbname=projet_1erannee", "root", ""); 
                
                // Recupere l'id du Users

               
                $select_opt= NULL;
                if ($_USER_ROLE == "Admin"){
                  $select_opt = "SELECT * FROM fraie";
                }
                else{
                  $select_opt = "SELECT * FROM fraie WHERE Id_Users = " . $_USER_ID . ";";
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
                  
                    // Préparer et exécuter une requête de suppression
                    $stmt = $pdo->prepare("DELETE FROM fraie WHERE Id_Fraie = ?");
                    
                    $stmt->execute([$id]);
                
                    // Rediriger vers la page d'affichage
                    header("Location: commercial.php");
                    exit();
                  
                    
                    
                    
                  }

                  // Vérifier si le formulaire a été soumis, Modifie le fraie

                 

                  echo '<td> 
                      <form method="post" action="commercial.php">
                        <input type="hidden" name="modify_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                        
                        <button type="button" class="btn btn-primary" onclick="editFrais('.$myarray_res[$i]['Id_Fraie'] .','. text2quote("commercial.php") .','. text2quote($myarray_res[$i]['Intitule']) .')" >
                          Modifier
                        </button>
                      </form>
                    </td>';
                  
                  // Modale de confirmation de suppression
                  echo '<td> 
                  <form method="post" action="commercial.php">
                    <input type="hidden" name="delete_fraie" value="'.$myarray_res[$i]['Id_Fraie'].'">
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                  </form>
                </td>';

                  echo "</tr>";



                }
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

    <!-- Ajouter Fraies -->


    <p class="h2 text-center mt-2">Ajouter un Fraie</p>

          <form action="commercial.php" class="container" method="POST">


          <div class="row mt-2 container">
            <div class="col-md-3"></div>
              <div class="col-md-6">
                <div class="row">
                  <div class="col-md-6">
                    <input type="text" placeholder="Intitulé" class="form-control" name="intitulé" require>
                  </div>
                  <div class="col-md-6">
                    <input type="date" placeholder="14/03/2023" class="form-control" name="date" require>
                  </div>
            </div>
            <div class="row">

              <div class="col-md-6 mt-2">
                <input type="number" placeholder="Prix" class="form-control" name="prix" required>
              </div>
              
              <?php
                  // Connexion à la base de données
                  $mysqli = mysqli_connect("localhost", "root", "", "projet_1erannee");
            
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
                <div class="form-group col-md-6 mt-2">
                    <select class="form-control" name="type" id="type">
                        <?php echo $options; ?>
                    </select>
                </div>


              
             

            </div>
            <p class="text-center mt-5"><button type="submit" class="btn btn-primary" name="delete-user">Ajouter</button></p>
        </form>
           </div>
          </div>


          <?php
            if (isset($_POST['intitulé']) && isset($_POST['date']) && isset($_POST['type'])) {
            
                // Connexion à la base de données
                $pdo = new PDO('mysql:host=localhost;dbname=projet_1erannee;charset=utf8mb4', 'root', '');
            
                // Récupération des données du formulaire
                $intitule = $_POST['intitulé'];
                $date = $_POST['date'];
                $type = $_POST['type'];
                $prix = $_POST['prix'];

                // Préparation et exécution de la requête SQL pour l'insertion des données
                $stmt = $pdo->prepare('INSERT INTO fraie (Intitule, prix, date_frais, id_paiement, Id_Type, Id_Users) VALUES (:intitule, :prix, :dateok, "3", :typeok, :iduser)');
                
                $stmt->bindParam(':intitule', $intitule);
                $stmt->bindParam(':prix', $prix);
						    $stmt->bindParam(':dateok', $date);
						    $stmt->bindParam(':typeok', $type);
                $stmt->bindParam(':iduser', $_USER_ID);
                

						    $stmt->execute();
              
                // Affichage d'un message de succès
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					  <strong>C est nickel</strong> l ajout est OK.
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>';
              
              //refresh la page js
              echo '<script type="text/javascript">
              setTimeout(function(){window.location = "commercial.php"}, 2000);
              </script>';

            }
            ?>





<script src="./utils.js"></script>
</body>
</html>