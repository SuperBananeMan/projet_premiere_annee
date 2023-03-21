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
    <link rel="icon" type="image/x-icon" href="./src/assets/ico.png">

    
    <title>ISA Compta</title>

</head>
<body>
    
    <?php
        
        session_start();
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
    <nav class="navbar navbar-expand-lg navbar_color">
        <!-- Container wrapper -->
        <div class="container ">
      <!-- Navbar brand -->
            <a class="navbar-brand" href="">
            <img
          src="src/assets/ico_x2.png"
          height="40"
          
          loading="lazy"
          style="margin-top: -1px;"
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
                <a class="nav-link text-dark " href="#">Dashboard</a>
              </li>
            </ul>
            <!-- Left links -->
            <?php

              echo '<div class="d-flex align-items-center ">
              
              '. $_USER_INIT . ' - ' . $_USER_ROLE .''
            
            
            
            ?>

            </div>
          </div>
          <!-- Collapsible wrapper -->
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->


          <!-- Main Content For Admin-->

        
    <div class="m-5">


      <script>let table = new DataTable('#myTable');</script>


        


        <p class="mt-4 h2 text-center">Tableau de Gestion Admin</p>

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
                $pdo = new PDO("mysql:host=localhost;dbname=projet_1erannee", "root", ""); 

                //role
                $role_name =[1 => "Admin", 2 => "Comptable", 3 => "Commercial"];

                // Vérifier si le formulaire a été soumis
                if(isset($_POST['delete_user'])) {
                    $id = $_POST['delete_user'];

                    // Préparer et exécuter une requête de suppression
                    $stmt = $pdo->prepare("DELETE FROM users WHERE Id_Users = ?");
                    $stmt->execute([$id]);

                    // Rediriger vers la page d'affichage
                    header("Location: index.php");
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>C est nickel</strong> le user a bien été supprimé
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                    exit();
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



      
    
      
      <!--Ajouter Users-->

      <div class="mt-5">

          
        <p class="h2 text-center">Ajouter un User</p>

        <form action="index.php" method="POST">


        <div class="row mt-4">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <input type="text" placeholder="E-Mail" class="form-control" name="email">
              </div>
              <div class="col-md-6">
                <input type="text" placeholder="Username" class="form-control" name="user">
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 mt-2">
                <input type="text" placeholder="Password" class="form-control" name="passwrd">
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


          <p class="text-center m-5"><button type="submit" class="btn btn-primary" name="delete-user">Ajouter</button></p>


        </form>

          
        <?php

					if (isset($_POST['email']) && isset($_POST['passwrd']) && isset($_POST['user'])){
						$email = $_POST['email'];
						$username = $_POST['user'];
						$passwrd = $_POST['passwrd'];
						$Id_role = $_POST['dropdown'];

            

						$db = new PDO('mysql:host=localhost;dbname=projet_1erannee;charset=utf8mb4', 'root', '');
		 
						$stmt = $db->prepare("INSERT INTO users (Nom, Mail, Passwrd, Id_role) VALUES (:username, :email, :passwrd, :Id_role)");
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

          
				
				?>
              


          <p class="h2 text-center">Ajouter un Fraie</p>

          <form action="index.php" method="POST">


          <div class="row mt-4">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-6">
                <input type="text" placeholder="Intitulé" class="form-control" name="intitulé">
              </div>
              <div class="col-md-6">
                <input type="date" placeholder="14/03/2023" class="form-control" name="date">
              </div>
            </div>
            <div class="row">
              
              <div class="form-group col-md-12 mt-2">
                
                <select class="form-control text-center" name="type" id="type">
                  
                  <option name="abc" value="1" selected>Repas</option>
                  <option name="abc" value="2">Transport</option>
                  <option name="abc" value="3">Essence</option>
                
                </select>
              </div>
             

            </div>
            <p class="text-center mt-5"><button type="submit" class="btn btn-primary" name="delete-user">Ajouter</button></p>
        </form>
           </div>
          </div>
          </form>

          <?php
            if (isset($_POST['intitulé']) && isset($_POST['date']) && isset($_POST['type'])) {
            
                // Connexion à la base de données
                $pdo = new PDO('mysql:host=localhost;dbname=projet_1erannee;charset=utf8mb4', 'root', '');
            
                // Récupération des données du formulaire
                $intitule = $_POST['intitulé'];
                $date = $_POST['date'];
                $type = $_POST['type'];
            
                // Préparation et exécution de la requête SQL pour l'insertion des données
                $stmt = $pdo->prepare('INSERT INTO fraie (Intitule, date_frais, id_paiement, Id_Type, Id_Users) VALUES (:intitule, :dateok, "3", :typeok, "1")');
                
                $stmt->bindParam(':intitule', $intitule);
					
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
          setTimeout(function(){window.location = "index.php"}, 2000);
          </script>';
              
            }
            ?>





        </div>    
    
    
    
 






</body>
</html>