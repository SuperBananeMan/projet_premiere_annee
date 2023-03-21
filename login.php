<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
	<link rel="icon" type="image/x-icon" href="./src/assets/ico.png">

    
    <title>Connexion</title>

</head>
<body class="content_body">
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar_color ">
        <!-- Container wrapper -->
        <div class="container">
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
	
	
	<div class="content_box">
    <div class="row d-flex justify-content-center">
		<div class="col-md-3 connexion_box">
			<h1 class="d-flex justify-content-center co">Connexion</h1>
			
		<form action="login.php" method="post">
				<h3 class="var">Email :</h3>
					<input type="email" id="co_email" name="co_email" class="inp"><br>
				<h3 class="var">Mot de passe :</h3>
					<input type="password" id="co_passwrd" name="co_passwrd" class="inp"><br>
					
				<div class="bouton">
				<div class="d-flex justify-content-center">
				<input type="submit" value="Se connecter" class="bouton_co"><br>
				</div>
				</div>
				
				<?php
				session_start();
				$_SESSION['user']=NULL;
				$_SESSION['role_u']=NULL;
				$_SESSION['id_u']=NULL;
				if (isset($_POST['co_passwrd']) && isset($_POST['co_email'])) {
					$co_email = $_POST['co_email'];
					$co_passwrd = $_POST['co_passwrd'];
					$success = false;
					$Role0=NULL;
					
					print_r($co_email,$co_passwrd);
					
					$db = new PDO('mysql:host=localhost;dbname=projet_1erannee;charset=utf8mb4', 'root', '');
	 
					$data = $db->query("SELECT * FROM users")->fetchAll();

					foreach ($data as $row){
						if ($row['Mail'] == $co_email && $row['Passwrd'] == $co_passwrd){
							$success = true;
							$Role0=$row['Id_Role'];
							$_SESSION['user']=$row['Nom'];
							$_SESSION['id_u']=$row['Id_Users'];
							echo"reussite !!!!!!";
							break;
						}
					}

					$data_role = $db->query("SELECT * FROM role")->fetchAll();
					foreach ($data_role as $row){
						if ($row['Id_Role'] == $Role0){
							$_SESSION['role_u']=$row['Nom_role'];
							break;
						}
					}

					if ($success){
						echo "Identifiants corrects : ".$_SESSION['user']." ".$_SESSION['role_u'];
						if ($_SESSION['role_u'] == "Admin"){
							header("Location: index.php");
						}
						if ($_SESSION['role_u'] == "Commercial"){
							header("Location: commercial.php");
						}
						if ($_SESSION['role_u'] == "Comptable"){
							header("Location: comptable.php");
						}
					}
					else{
						echo "Identifiants incorrects";
					}
				}
				?>
			</form>
		</div>
	</div>
	</div>






</body>
</html>