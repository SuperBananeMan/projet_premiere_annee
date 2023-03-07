<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="src/styleheet.css">
    <link rel="icon" type="image/x-icon" href="./src/assets/ico.png">

    
    <title>ISA Compta</title>

</head>
<body>
    
    <?php

        session_start();
        

    
    
    
    
    
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

              <div class=" col-md-6 mt-5 pt-5">                                     <!-- Partie gauche avec le tableau-->


                <table id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prenom</th>
                            <th>Mail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Connexion à votre base de données
                        $pdo = new PDO("mysql:host=localhost;dbname=projet_1erannee", "root", ""); 
                        // Exécuter une requête pour récupérer les données
                        $resultat = $pdo->query("SELECT * FROM users");  
                        // Boucle pour afficher les résultats de la requête
                        foreach ($resultat as $row) {
                            echo "<tr>";
                            echo "<td>" . $row['Id_Users'] . "</td>";
                            echo "<td>" . $row['Prenom'] . "</td>";
                            echo "<td>" . $row['Nom'] . "</td>";
                            echo "<td>" . $row['Mail'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                      </tbody>
                </table>
                      
                <script>
                    $(document).ready(function() {
                        $('#myTable').dataTable();
                    });
                </script>

                  
              <div>
            </div>    
        </div>    



    <!-- Main Content For Comptable-->






    <!-- Main Content For Commerciale-->








</body>
</html>