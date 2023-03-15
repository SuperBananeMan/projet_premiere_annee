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
        if (isset($_SESSION['user'])) {
            $_USER_INIT = $_SESSION['user'];
            $_USER_ROLE = $_SESSION['role_u'];
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
			if ($_USER_ROLE != "Comptable"){
				if ($_USER_ROLE == "Admin"){
        }
        else{
          header("location:403.html");
        }
			}
        } else {
            echo "Vous n'êtes pas connecté";
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


    <!-- Main Content -->


    
	
	<div class="row">
		<div class="col-md-6 mt-5 pt-5 a_droite">
			<table id="myTable">
              <thead>
                <tr>
                  <th>Intitulé</th>
                  <th>Date fraie</th>
                  <th>Pièce jointe</th>
				  <th>Paiement</th>
				  <th>Type</th>
				  <th>Nom Utilisateur</th>
				  <th>Prénom Utilisateur</th>
				  <th></th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php
				// Connexion à votre base de données
                $pdo = new PDO("mysql:host=localhost;dbname=projet_1erannee", "root", ""); 
                // Exécuter une requête pour récupérer les données
                $resultat = $pdo->query("SELECT * FROM fraie");  
				$data = $pdo->query("SELECT * FROM users"); 
				//identifier l'utilisateur
                // Boucle pour afficher les résultats de la requête
                foreach ($resultat as $row) {
					echo "<tr>";
					echo "<td>" . $row['Intitulé'] . "</td>";
					echo "<td>" . $row['date_frais'] . "</td>";
					echo "<td>" . $row['id_paiement'] . "</td>";
					echo "<td>" . $row['Id_Type'] . "</td>";
					foreach ($data as $nom){
						if ($row['Id_Users'] == $nom['Id_Users']){
							$le_nom = $nom['Nom'];
							//$le_prenom = $nom['Prenom'];
							break;
						}
					}
					echo "<td>" . $le_nom . "</td>";
					//echo "<td>" . $le_prenom . "</td>";
					echo '<form action="login.php" method="post">';
					echo "<td><input type='submit' value='Accepter' class='bouton_acc'></td>";
					echo "<td><input type='submit' value='Refuser' class='bouton_ref'></td>";
					if(isset($_GET['button_acc'])) {
						echo "This is Button1 that is selected";
					}
					if(isset($_GET['button_ref'])) {
						echo "This is Button2 that is selected";
					}
					echo '</form>';
                  echo "</tr>";
                }
                ?>
				<?php     
					
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
			<style>.a_droite{margin-left:50px;}</style>
		</div>
	</div>


</body>
</html>