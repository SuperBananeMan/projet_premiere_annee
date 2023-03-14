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
			if ($_USER_ROLE != "Commercial"){
				$_USER_WRONG_PAGE = true;
				sleep(5);
				$_SESSION['wrong_page'] = $_USER_WRONG_PAGE;
				if ($_USER_ROLE == "Comptable"){
					header("Location: comptable.php");
				}
				if ($_USER_ROLE == "Admin"){
					header("Location: index.php");
				}
			}
        } else {
            echo "Vous n'êtes pas connecté";
        }
		if ($_SESSION['wrong_page']==true){
			echo "Vous avez essayé d'aller sur une page dont vous n'avez pas l'autorisation d'aller.";
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


    <?php
	if (isset($_SESSION['wrong_page'])) {
		if ($_SESSION['wrong_page']==true){
			echo "Vous avez essayé d'aller sur une page dont vous n'avez pas l'autorisation d'aller.";
		}
	}
	?>


   







</body>
</html>