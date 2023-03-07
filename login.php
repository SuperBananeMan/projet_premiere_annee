<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    
    <title>Connexion</title>

</head>
<body>
    <div class="row d-flex justify-content-center">
		<div class="col-md-3">
			<h1 class="d-flex justify-content-center">Connexion</h1>
			
		<form action="login.php" method="post">
				<h3 class="var">Identifiant :</h3>
					<input type="text" id="co_username" name="co_username" class="inp"><br>
				<h3 class="var">Mot de passe :</h3>
					<input type="password" id="co_passwrd" name="co_passwrd" class="inp"><br>
				<h3 class="var">Email :</h3>
					<input type="email" id="co_email" name="co_email" class="inp"><br>
				<!--<h3>Code d'activation :</h3>
					<input type="text" id="code-activation" name="code-activation"><br>-->
				<input type="submit" value="Se connecter"><br>
				<input type="reset" value="Effacer"><br>
				
				<?php
				session_start();
				if (isset($_POST['co_username']) && isset($_POST['co_passwrd']) && isset($_POST['co_email'])) {
					$co_username = $_POST['co_username'];
					$co_passwrd = $_POST['co_passwrd'];
					$co_email = $_POST['co_email'];
					$success = false;
					
					$db = new PDO('mysql:host=localhost;dbname=projet_1erannee;charset=utf8mb4', 'root', '');
	 
					$data = $db->query("SELECT * FROM users")->fetchAll();

					foreach ($data as $row){
						if ($row['username'] == $co_username && $row['passwrd'] == $co_passwrd && $row['email'] == $co_email){
							$success = true;
							break;
						}
					}
					if ($success){
						header("Location: reussite.php");
					}
					else{
						header("Location: erreur.php");
					}
				}
				?>
			</form>
		</div>
	</div>






</body>
</html>