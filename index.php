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
                    echo "Admin ". $_USER_INIT;
                    break;
                case 'Comptable':
                    //code...
                    echo "Comptable ". $_USER_INIT;
                    break;
                case 'Commercial':
                    //code...
                    echo "Commercial ". $_USER_INIT;
                    break;
                default:
                    echo "Error user role 01";
                    break;
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
        
            <div class="d-flex align-items-center ">
              <button type="button" class="btn button_color  me-2">
                <a class="text-light text_deco" href="login.php">Login</a>
              </button>
              

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

        <p class="h1 text-center">Tableau de Gestion Admin</p>

        <div class="row">
          <div class="col-md-6 mt-5 pt-5"> <!-- Partie gauche avec le tableau-->
            <table id="myTable">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Mail</th>
                  <th>Role</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Connexion à votre base de données
                $pdo = new PDO("mysql:host=localhost;dbname=projet_1erannee", "root", ""); 
                // Exécuter une requête pour récupérer les données
                $resultat = $pdo->query("SELECT * FROM users");  
                //role
                $role_name =[1 => "Admin", 2 => "Comptable", 3 => "Commercial"];
                // Boucle pour afficher les résultats de la requête
                foreach ($resultat as $row) {
                  echo "<tr>";
                  echo "<td>" . $row['Id_Users'] . "</td>";
                  echo "<td>" . $row['Prenom'] . "</td>";
                  echo "<td>" . $row['Nom'] . "</td>";
                  echo "<td>" . $row['Mail'] . "</td>";
                  echo "<td>" . $role_name[$row['Id_Role']] . "</td>";
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



      <div class=" col-md-6 mt-5 pt-5">                                     <!-- Partie droite avec les boutons-->


          <form action="" method="POST">
            <div class="form-group">
              <label for="select-user">Sélectionnez un utilisateur :</label>
              <select class="form-control" id="select-user" name="select-user">
                <?php
                // Connexion à la base de données
                $conn = mysqli_connect("localhost", "root", "", "projet_1erannee");
                if (!$conn) {
                  die("Connexion échouée : " . mysqli_connect_error());
                }
              
                // Récupération de la liste des utilisateurs
                $sql = "SELECT * FROM Users";
                $result = mysqli_query($conn, $sql);
              
                // Création des options du menu déroulant
                while ($row = mysqli_fetch_assoc($result)) {
                  echo '<option value="' . $row['Id_Users'] . '">' . $row['Nom'] . ' ' . $row['Prenom'] . '</option>';
                }
              
                // Fermeture de la connexion à la base de données
                mysqli_close($conn);
                ?>
              </select>
            </div>
            <p class="text-center m-5"><button type="submit" class="btn btn-danger" name="delete-user">Supprimer</button></p>
          </form>
          <?php
          // Traitement de la suppression d'un utilisateur
          if (isset($_POST['delete-user'])) {
            // Récupération de l'id de l'utilisateur sélectionné dans le menu déroulant
            $selected_user = $_POST['select-user'];
          
            // Connexion à la base de données
            $conn = mysqli_connect("localhost", "root", "", "projet_1erannee");
            if (!$conn) {
              die("Connexion échouée : " . mysqli_connect_error());
            }
          
            // Suppression de l'utilisateur sélectionné
            $sql = "DELETE FROM Users WHERE Id_Users = '$selected_user'";
            if (mysqli_query($conn, $sql)) {
              echo '<div class="alert alert-success">Utilisateur supprimé avec succès.</div>';
            } else {
              echo '<div class="alert alert-danger">Erreur lors de la suppression de l\'utilisateur : ' . mysqli_error($conn) . '</div>';
            }
          
            // Fermeture de la connexion à la base de données
            mysqli_close($conn);
          }
          ?>
        </div>
      </div>
    
      
      <!--Ajouter Users-->

      <div class="m-5">

          
        <p class="h2 text-center">Ajouter un User</p>


          <div class="row">
              
          

              <form action="" method="POST">
                <div class="form-group mt-3 ">
                    
                    <label for="select-user">Prenom</label>
                    <input class="" id="select-user" name="select-user">

                    <label for="select-user">Nom</label>
                    <input class="" id="select-user" name="select-user">

                    <label for="select-user">Mail</label>
                    <input class="" id="select-user" name="select-user">

                    <label for="select-user">Role</label>
                    <input class="" id="select-user" name="select-user">
              

                    





              




              </div>


          <div>







      </div>

      
    
    
    
    
    
    </div>    
  </div>    
</div>



    <!-- Main Content For Comptable-->






    <!-- Main Content For Commerciale-->








</body>
</html>