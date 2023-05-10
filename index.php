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
    <link rel="stylesheet" href="src/styleheet.css">
    <link rel="icon" type="image/x-icon" href="./src/assets/logo-v2.png">

    <script src="utils.js" crossorigin="anonymous"></script>

    
    <title>ISA Compta</title>

</head>
<body>
    
    <?php

        session_start();
        require('utils.php');
        $_USER_INIT= NULL;
        $_USER_ROLE= NULL;
        $_USER_ID= NULL;
		    $_USER_WRONG_PAGE= false;
        if (isset($_SESSION['user'])) {
            $_USER_INIT = $_SESSION['user'];
            $_USER_ROLE = $_SESSION['role_u'];
            $_USER_ID = $_SESSION['id_u'];
        }
        //en tant qu'exemple
        if ($_USER_INIT != NULL) {
            switch ($_USER_ROLE) {
                case 'Admin':
                    //code...
                    break; 
                case 'Comptable':
                    //code...
                    break;
                case 'Commercial':
                    //code...
                    break;
                default:
                    echo "Error user role 01";
                    break;
            }
			if ($_USER_ROLE != "Admin"){
				header("location:403.html");
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


          <!-- Main Content For Admin-->

        
    <div class="m-5">


      <script>let table = new DataTable('#myTable');</script>


        

	<div class="all_center container myTitreDiv">
        <h2 class="text-center mt-4 myTitre all_center">Tableau de Gestion Admin</h2>
	</div>
	
        <div class="row">
          <div class=" mt-5 pt-5"> <!-- Partie gauche avec le tableau-->
            <table id="myTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Mail</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                // Connexion à votre base de données
                $pdo = getDB();
                

                //role
                $role_name =[1 => "Admin", 2 => "Comptable", 3 => "Commercial"];

                // Vérifier si le formulaire a été soumis
                if(isset($_POST['delete_user'])) {
                    $id = $_POST['delete_user'];
                    //verif si l'id est bien un int (pour eviter les injections sql)
                    if (filter_var($id, FILTER_VALIDATE_INT) === false) {
                      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Erreur</strong> l id n est pas un int
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
                      //refresh la page js
                      echo '<script type="text/javascript">
                      setTimeout(function(){window.location = "index.php"}, 1800);
                      </script>';
                      exit();
                    }
                    if (is_numeric($id) == true){

                        // Préparer et exécuter une requête de suppression
                        $stmt = $pdo->prepare("DELETE FROM users WHERE Id_Users = ?");
                        $stmt->execute([$id]);


                        // Rediriger vers la page d'affichage
                        //header("Location: index.php");
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>C est nickel</strong> le user a bien été supprimé
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    }
                    //exit();
                    //refresh la page js
                    echo '<script type="text/javascript">
                    setTimeout(function(){window.location = "index.php"}, 1800);
                    </script>';

                
                }

                // Exécuter une requête pour récupérer les données
                $resultat = $pdo->query("SELECT * FROM users");  


                // Boucle pour afficher les résultats de la requête
                foreach ($resultat as $row) {
                    echo "<tr>";
                    echo "<td>" . $row['Id_Users'] . "</td>";
                    echo "<td>" . $row['Nom'] . "</td>";
                    echo "<td>" . $row['Mail'] . "</td>";
                    echo "<td>" . $role_name[$row['Id_Role']] . "</td>";
                    echo '<td> 
                            <form method="post" action="index.php">
                              <input type="hidden" name="delete_user" value="'.$row['Id_Users'].'">
                              <button id="del_user_btn" type="button" onclick="deleteUser('. $row['Id_Users'] .','. text2quote("index.php") . ','. text2quote($row['Mail']) .')" class="btn btn-danger">Supprimer</button>
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



      
    
      
      <!--Ajouter Users-->

      <div class="mt-5">

          
        <p class="h2 text-center">Ajouter un User</p>

        <form action="index.php" method="POST">


        <div class="row mt-4">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <input type="text" placeholder="E-Mail" class="form-control" name="email" required>
              </div>
              <div class="col-md-6">
                <input type="text" placeholder="Username" class="form-control" name="user" required>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mt-2">
                <input type="text" placeholder="Password" class="form-control" name="passwrd" required>
              </div>
              <div class="form-group col-md-6 mt-2">
                
                <select class="form-control" name="dropdown" id="dropdown">
                  
                  <option name="abc" value="1" selected>Admin</option>
                  <option name="abc" value="2">Comptable</option>
                  <option name="abc" value="3">Commercial</option>
                
                </select>
              </div>

            </div>
           </div>
          </div>


          <p class="text-center"><button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#confirmUModal">Ajouter</button></p>

                <!-- Popup de confirmation de l'ajout du frais -->
                <div class="modal fade" id="confirmUModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmation de l'ajout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center">
                        Êtes-vous sûr de vouloir ajouter cet utilisateur ?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="confirmAddU">Ajouter</button>
                      </div>
                    </div>
                  </div>
                </div>

        </form>

          
        <?php

					if (isset($_POST['email']) && isset($_POST['passwrd']) && isset($_POST['user'])){
						$email = $_POST['email'];
						$username = $_POST['user'];
						$passwrd = $_POST['passwrd'];
						$Id_role = $_POST['dropdown'];

            //hashage du mdp
            $passwrd = hash_password_rpd($passwrd, get_salt());

            //verif si l'email est valide
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              
              echo '
              <script type="text/javascript">
              popupForm_valide("Erreur", "Mail incorecte.<br>", function() {
                //on recharge la page après avoir fermé le popup
                window.location = "index.php";
            }, "ok");
              </script>';


            
            }

            else{

            

						$pdo = getDB();

            //verif si l'email existe deja
            $stmt = $pdo->prepare("SELECT * FROM users WHERE Mail = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
              echo '
              <script type="text/javascript">
              popupForm_valide("Erreur", "Mail deja existant.<br>", function() {
                //on recharge la page après avoir fermé le popup
                window.location = "index.php";
            }, "ok");
              </script>';
            }

            else{
		 
						  $stmt = $pdo->prepare("INSERT INTO users (Nom, Mail, Passwrd, Id_role) VALUES (:username, :email, :passwrd, :Id_role)");
						  $stmt->bindParam(':username', $username);
              
						  $stmt->bindParam(':passwrd', $passwrd);
						  $stmt->bindParam(':email', $email);
						  $stmt->bindParam(':Id_role', $Id_role);
              
						  $stmt->execute();
              
						  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					    <strong>C est nickel</strong> l ajout est OK.
					    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					    </div>';

              //refresh la page js
              echo '<script type="text/javascript">
              setTimeout(function(){window.location = "index.php"}, 2000);
              </script>';
              }

            }
					
					}

          
				
				?>
              


        <p class="h2 text-center mt-5 mb-5">Ajouter un Frais</p>

          <form action="index.php" class="container" method="POST">


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
          

            
            mysqli_close($mysqli);
          
          
            ?>

            </div>
            <!--<p class="text-center mt-5"><button type="submit" class="btn btn-primary" name="delete-user">Ajouter</button></p>-->
            <p class="text-center mt-5"><button type="button" class="btn btn-primary" onclick="addFrais('index.php')">Ajouter</button></p>
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

          
          
          
          
      </div>   
        
        <p class="h2 text-center mt-5">Ajouter un Type de Frais</p>

          <form action="index.php" method="POST">


          <div class="row mt-4">
            <div class="col-md-3"></div>
              <div class="col-md-6">
                  <div class="row">
                    <div class="col-md-12 text-center">
                      <input type="text" placeholder="Intitulé" class="form-control text-center" name="intituléF" required>
                    </div>
                  </div>
                </div>
                <p class="text-center"><button type="button" class="btn btn-primary mt-5" data-bs-toggle="modal" data-bs-target="#confirmTModal">Ajouter</button></p>

                <!-- Popup de confirmation de l'ajout du frais -->
                <div class="modal fade" id="confirmTModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmation de l'ajout</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center">
                        Êtes-vous sûr de vouloir ajouter ce type de frais ?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="confirmAddT">Ajouter</button>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          
          </form>
           

          <?php
            if (isset($_POST['intituléF'])) {
            
                // Connexion à la base de données
                $pdo = getDB();
            
                // Récupération des données du formulaire
                $intituleF = $_POST['intituléF'];
                
            
                // Préparation et exécution de la requête SQL pour l'insertion des données
                $stmt = $pdo->prepare('INSERT INTO type (Nom) VALUES (:intituleF)');
                
                $stmt->bindParam(':intituleF', $intituleF);
                

						    $stmt->execute();
              
                // Affichage d'un message de succès
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					  <strong>C est nickel</strong> l ajout est OK.
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>';

          //refresh la page js
          echo '<script type="text/javascript">
          setTimeout(function(){window.location = "index.php"}, 2000);
          </script>';
              
            }
            ?>
    
    
    
 





<script src="./utils.js"></script>
</body>
</html>