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

    
    <title>ISA Compta</title>

</head>
<body>
    
    <?php

        session_start();
		require('utils.php');
        $_USER_INIT= NULL;
        $_USER_ROLE= NULL;
        $_USER_ID = NULL;
		
		
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
            
          	if ($_USER_ROLE != "Comptable"){
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


    <!-- Main Content -->

	<div class="all_center container myTitreDiv">
		<h1 class="text-center mt-4 myTitre all_center">Les Frais En Cours</h1>     
	</div> 
  

	
	<div class="container">
		<div class="mt-5 pt-5 a_droite">
			<table id="myTable">
				<thead>
					<tr>
						<th>Intitulé</th>
						<th>Prix</th>
						<th>Date frais</th>
						<th>Type</th>
						<th>Pièce-Jointe</th>
						<th>Paiement</th>
						<th>Accepter</th>
						<th>Refuser</th>
					</tr>
				</thead>
				<tbody>
        <?php
			// function checkType($type,$row){
			// 	echo $row['Id_Type'];
			// 	$array_type = (array) $type;
			// 	for($i = 1; $i <= count($array_type); $i++){
			// 		echo $row['Id_Type'] . $i;
			// 		if ($row['Id_Type'] == $i){
			// 			$le_type = $array_type[$i]['Nom'];
			// 			return ($le_type);
			// 		}
			// 	}
			// }
			
			
			// Connexion à votre base de données
            $pdo = getDB();            // Exécuter une requête pour récupérer les données
            $resultat = $pdo->query("SELECT * FROM fraie WHERE id_paiement = 3");
			      $data = $pdo->query("SELECT * FROM users");
			      $etat = $pdo->query("SELECT * FROM etat");
			      $type = $pdo->query("SELECT * FROM type");

            // Declaration des tableaux
            
            $typeT = array();   
            $etatE = array();
            
            // Accepter le fraie
            if(isset($_POST['accept'])) {
				

				        $accept = $_POST['accept'];
				        // Préparer et exécuter une requête de suppression
				        $stmt = $pdo->prepare("UPDATE fraie SET id_paiement ='2' WHERE Id_Fraie = ?");
				        $stmt->execute([$accept]);
				        // Rediriger vers la page d'affichage
				        header("Location: comptable.php");

				        exit();
            }

            // Refuser le fraie
            if(isset($_POST['refuse'])) {
				

				        $refuse = $_POST['refuse'];
				        // Préparer et exécuter une requête de suppression
				        $stmt = $pdo->prepare("UPDATE fraie SET id_paiement ='1' WHERE Id_Fraie = ?");
				        $stmt->execute([$refuse]);
				        // Rediriger vers la page d'affichage
				        header("Location: comptable.php");

				        exit();
            }

				    //identifier l'utilisateur
          // Boucle pour rentrer les résultats de la requête type dans le tab

          foreach($type as $rowT){

            $typeT[$rowT['Id_Type']] = $rowT['Nom'];
              

          }     
          
          // Boucle pour rentrer les résultats de la requête etat dans le tab


          foreach($etat as $rowE){

            $etatE[$rowE['id_paiement']] = $rowE['type_paiement'];
              

          } 
          
          // Boucle pour afficher les résultats de la requête fraie


          foreach ($resultat as $row) {
						echo "<tr>";
						echo "<td>" . $row['Intitule'] . "</td>";
						echo "<td>" . $row['prix'] . " €</td>";

						echo "<td>" . $row['date_frais'] . "</td>";
							
            			echo '<td>' . $typeT[$row["Id_Type"]] . '</td>';
						
						//echo "<td><a href=". $row['file_frais'] . "  target='_blank'>Voir</a></td>";
						if ($row['file_frais'] != NULL){
							echo '<td><a type="button" class="btn btn-secondary" href="./download.php/?id='.$row['Id_Fraie'].'" target="_blank">Télécharger</a></td>';
						}
						else{
							echo "<td> NaN </td>";
						}



					
						echo "<td>" . $etatE[$row['id_paiement']] . "</td>";


						
						// $le_type = checkType($type,$row);
						

						/*if ($row['Id_Type'] == 1){
							$nomType = "Repas";
						}
						elseif ($row['Id_Type'] == 2){
							$nomType = "Transport";
						}
						elseif ($row['Id_Type'] == 3){
							$nomType = "Essence";
						}
						else{
						  $nomType = "";
						}*/


						// echo "<td>" . $nomType . "</td>";
						
						// echo "<td>" . $le_type . "</td>";
						
						foreach ($data as $nom){
							if ($row['Id_Users'] == $nom['Id_Users']){
								$le_nom = $nom['Nom'];
								//$le_prenom = $nom['Prenom'];
								break;
							}
						}
					
					
						
						echo '<td> 
							<form method="post" action="comptable.php">
							<input type="hidden" name="accept" value="'.$row['Id_Fraie'].'">
							<button id="accepter" type="button" class="btn btn-primary" onclick="valideFrais(\'accepter\','. $row['Id_Fraie'] .','. text2quote("comptable.php") . ','. text2quote($row['Intitule']) .')">Accepter</button>
							</form>
							</td>'  ;

						echo '<td> 
							<form method="post" action="comptable.php">
							<input type="hidden" name="refuse" value="'.$row['Id_Fraie'].'">
							<button id="refuser" type="button" class="btn btn-danger" onclick="valideFrais(\'refuser\','. $row['Id_Fraie'] .','. text2quote("comptable.php") . ','. text2quote($row['Intitule']) .')">Refuser</button>
							</form>
							</td>';

						echo "</tr>";
					}

					//compte le nombre de ligne dans la table
					$nb_ligne = $resultat->rowCount();
					//echo "<p>Il y a $nb_ligne lignes dans la table</p>";
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


  <div class="all_center container myTitreDiv">
		<h1 class="text-center mt-4 myTitre all_center">Les Frais Traités </h1>     
	</div> 
    
	
	<div class="container">
		<div class="mt-5 pt-5 a_droite">
			<table id="myTable_2">
				<thead>
					<tr>
						<th>Intitulé</th>
						<th>Prix</th>
						<th>Date frais</th>
						<th>Type</th>
						<th>Pièce-Jointe</th>
						<th>Paiement</th>
						
            <?php 
                  
                  
                if ($_USER_ROLE == "Admin"){

                  echo '<th>Accepter</th>';
                  echo '<th>Refuser</th>';

                }
                  
                  
            ?>
            
            
            
					</tr>
				</thead>
				<tbody>
        <?php
			// function checkType($type,$row){
			// 	echo $row['Id_Type'];
			// 	$array_type = (array) $type;
			// 	for($i = 1; $i <= count($array_type); $i++){
			// 		echo $row['Id_Type'] . $i;
			// 		if ($row['Id_Type'] == $i){
			// 			$le_type = $array_type[$i]['Nom'];
			// 			return ($le_type);
			// 		}
			// 	}
			// }
			
			
			// Connexion à votre base de données
            $pdo = getDB();            // Exécuter une requête pour récupérer les données
            $resultat = $pdo->query("SELECT * FROM fraie WHERE id_paiement != 3");
			      $data = $pdo->query("SELECT * FROM users");
			      $etat = $pdo->query("SELECT * FROM etat");
			      $type = $pdo->query("SELECT * FROM type");

            // Declaration des tableaux
            
            $typeT = array();   
            $etatE = array();
            
            // Accepter le fraie
            if(isset($_POST['accept'])) {
				

				        $accept = $_POST['accept'];
				        // Préparer et exécuter une requête de suppression
				        $stmt = $pdo->prepare("UPDATE fraie SET id_paiement ='2' WHERE Id_Fraie = ?");
				        $stmt->execute([$accept]);
				        // Rediriger vers la page d'affichage
				        header("Location: comptable.php");

				        exit();
            }

            // Refuser le fraie
            if(isset($_POST['refuse'])) {
				

				        $refuse = $_POST['refuse'];
				        // Préparer et exécuter une requête de suppression
				        $stmt = $pdo->prepare("UPDATE fraie SET id_paiement ='1' WHERE Id_Fraie = ?");
				        $stmt->execute([$refuse]);
				        // Rediriger vers la page d'affichage
				        header("Location: comptable.php");

				        exit();
            }

				    //identifier l'utilisateur
          // Boucle pour rentrer les résultats de la requête type dans le tab

          foreach($type as $rowT){

            $typeT[$rowT['Id_Type']] = $rowT['Nom'];
              

          }     
          
          // Boucle pour rentrer les résultats de la requête etat dans le tab


          foreach($etat as $rowE){

            $etatE[$rowE['id_paiement']] = $rowE['type_paiement'];
              

          } 
          
          // Boucle pour afficher les résultats de la requête fraie


          foreach ($resultat as $row) {
						echo "<tr>";
						echo "<td>" . $row['Intitule'] . "</td>";
						echo "<td>" . $row['prix'] . " €</td>";

						echo "<td>" . $row['date_frais'] . "</td>";
							

            			echo '<td>' . $typeT[$row["Id_Type"]] . '</td>';

						//echo "<td><a href=". $row['file_frais'] . "  target='_blank'>Voir</a></td>";
						if ($row['file_frais'] != NULL){
							echo '<td><a type="button" class="btn btn-secondary" href="./download.php/?id='.$row['Id_Fraie'].'" target="_blank">Télécharger</a></td>';
						}
						else{
							echo "<td> NaN </td>";
						}

					
						echo "<td>" . $etatE[$row['id_paiement']] . "</td>";


						
						// $le_type = checkType($type,$row);
						

						/*if ($row['Id_Type'] == 1){
							$nomType = "Repas";
						}
						elseif ($row['Id_Type'] == 2){
							$nomType = "Transport";
						}
						elseif ($row['Id_Type'] == 3){
							$nomType = "Essence";
						}
						else{
						  $nomType = "";
						}*/


						// echo "<td>" . $nomType . "</td>";
						
						// echo "<td>" . $le_type . "</td>";
						
						foreach ($data as $nom){
							if ($row['Id_Users'] == $nom['Id_Users']){
								$le_nom = $nom['Nom'];
								//$le_prenom = $nom['Prenom'];
								break;
							}
						}
					
					
          if ($_USER_ROLE == "Admin"){
						
						echo '<td> 
							<form method="post" action="comptable.php">
							<input type="hidden" name="accept" value="'.$row['Id_Fraie'].'">
							<button id="accepter" type="button" class="btn btn-primary" onclick="valideFrais(\'accepter\','. $row['Id_Fraie'] .','. text2quote("comptable.php") . ','. text2quote($row['Intitule']) .')">Accepter</button>
							</form>
							</td>'  ;

						echo '<td> 
							<form method="post" action="comptable.php">
							<input type="hidden" name="refuse" value="'.$row['Id_Fraie'].'">
							<button id="refuser" type="button" class="btn btn-danger" onclick="valideFrais(\'refuser\','. $row['Id_Fraie'] .','. text2quote("comptable.php") . ','. text2quote($row['Intitule']) .')">Refuser</button>
							</form>
							</td>';

						echo "</tr>";
					}}
                  ?>

                  
				</tbody>
            </table>
			<script>
			$(document).ready(function() {
			$('#myTable_2').DataTable( {
        order: [[4, 'asc']],
				"language": {
				"url": "https://cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
				}
			} );
			} );
            
            </script>
		</div>
	</div>

	<!--toast-->


	<div class="toast position-sticky p-3 bottom-0 end-0" id="myToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
  <div class="toast-header" data-bs-autohide="false">
    <img src="./src/assets/logo-v2.png" class="rounded me-2" alt="..." style="width: 2em;heigth: 2em;">
    <strong class="me-auto">INFO</strong>
    <small class="text-muted"><?php
	date_default_timezone_set('Europe/Paris');
	$date = date("d-m-Y");
	
	$heure = date("H:i");//
	echo "Le $date à $heure";
	?>
	</small>
    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
    <?php
	echo "Bonjour ".$_SESSION['user']." !";
	echo "<br>";
	echo "Il vous reste <strong>". $nb_ligne . "</strong> frais à traiter.";
	?>
  </div>
</div>
<script>
document.addEventListener("DOMContentLoaded", function(){
    
    var element = document.getElementById("myToast");
	var nb_ligne = <?php echo $nb_ligne; ?>;

	<?php
	//echo "var sess_dt = '". $_SESSION['usr_date'] . "';";
	//echo "var sess_hr = '". date("d/m/Y") . "';";

	if (text2quote($_SESSION['usr_date']) == text2quote(date("d/m/Y")) && $_SESSION['compt_fco'] == 0){
		echo "var boolval = false;";
	}
	else{
		echo "var boolval = true;";
		$_SESSION['compt_fco'] = 0;
	}

	?>

	

    // Create toast instance
    var myToast = new bootstrap.Toast(element);

    if (nb_ligne > 0 && boolval == true){
        myToast.show();
	}
	else{
		myToast.hide();
	}
    
});
</script>


<script src="./utils.js"></script>
</body>
</html>