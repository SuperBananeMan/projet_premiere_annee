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

    
    <title>Inscription</title>

</head>
<body>
    <div class="row d-flex justify-content-center">
		<div class="col-md-3">
			<h1 class="d-flex justify-content-center">Inscription</h1>
			<form action="register.php" method="post">
				<h3 class="var">Identifiant :</h3>
					<input type="text" id="user" name="user" class="inp"><br>
				<h3 class="var">Mot de passe :</h3>
					<input type="password" id="passwrd" name="passwrd" class="inp"><br>
				<h3 class="var">Vérification mot de passe :</h3>
					<input type="password" id="verif-pass-word" name="verif-pass-word" class="inp"><br>
				<h3 class="var">Email :</h3>
					<input type="email" id="email" name="email" class="inp"><br>
				<input type="submit" value="S'inscrire" id="enregistrer"><br>
				<input type="reset" value="Effacer"><br>
				
				<?php
					if (isset($_POST['email']) && isset($_POST['passwrd']) && isset($_POST['user'])){
						$email = $_POST['email'];
						$username = $_POST['user'];
						$passwrd = $_POST['passwrd'];
		 
						$db = new PDO('mysql:host=localhost;dbname=projet_1erannee;charset=utf8mb4', 'root', '');
		 
						$stmt = $db->prepare("INSERT INTO users (username, passwrd, email) VALUES (:username, :passwrd, :email)");
						$stmt->bindParam(':username', $username);
						$stmt->bindParam(':passwrd', $passwrd);
						$stmt->bindParam(':email', $email);
		 
						$stmt->execute();
		 
						echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
					  <strong>C est nickel</strong> l ajout est OK.
					  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>';
					
					}


				
				?>
				
			</form>
		</div>
</body>
</html>