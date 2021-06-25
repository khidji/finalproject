<?php

session_start();

// on vient inclure l'autoload de composer pour avoir accès au chargement automatiques des class (perso/externe)
require_once __DIR__ . '/vendor/autoload.php';


// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Final project</title>

		<link rel="stylesheet" href="assets/css/style.css">
	</head>

	<body>
		<header>
			<div>
				<a href="/">
					<img src="../assets/images/logo/logo.svg" alt="">
				</a>
			</div>
			<nav>
				<ul>
					<li><a href="/">Accueil</a></li>
					<li><a href="annonces.php">Annonces</a></li>
					<li><a href="profile.php">Mon compte</a></li>
					<li><a href="logout.php">se déconnecter</a></li>
				</ul>
			</nav>
		</header>
		<main>
			<h1>Bienvenue
				<?=$user['first_name'];?>
			</h1>
      <p>Tu es sur ton compte voici tes informations:
      Tu t'appelles 				
      <?=$user['first_name'];?> <?=$user['last_name'];?> !
      Ton pseudo est <?=$user['pseudo'];?>
      </p>
      <h1>T'as besoin d'aide ? Crée une demande ici</h1>
      <a href="newpost.php">
      <button > Nouvel article</button>
      </a>

		</main>
		<footer>&copy; J'ai besoin d'aide 2021</footer>
	</body>

</html>