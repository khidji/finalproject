<?php

session_start();

// on vient inclure l'autoload de composer pour avoir accès au chargement automatiques des class (perso/externe)
// on inclu database pour récupérer le pdo
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';


// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
}

$user = $_SESSION['user'];

$articles = $pdo->query('SELECT * FROM posts ORDER BY id DESC');



?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Final project</title>

		<link rel="stylesheet" href="assets/css/style.css">
		<link rel="stylesheet" href="assets/css/home.css">

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
					<li><a href="categories.php">Toutes les catégories</a></li>
					<li><a href="profile.php">Mon compte</a></li>
					<li><a href="logout.php">se déconnecter</a></li>
				</ul>
			</nav>
		</header>
		<main>
			<h1 class="welcome">Bienvenue
				<?=$user['pseudo'];?>
			</h1>
      		<p class="p_home">T'as besoin d'aide ? Alors <a class="a_newpost" href="newpost.php"> crée une demande d'aide</a> ! </p>
			<h2 class="h2_home">Dernières publications:</h2>
			<ul>
				<?php while ($a = $articles->fetch()) { ?>
				<li class ="lien_article"> <a href="article.php?id=<?= $a['id'] ?>"> <?= $a['title']?> </a> </li>
				<?php } ?>
			</ul>

		</main>
		<footer>&copy; J'ai besoin d'aide 2021</footer>
	</body>

</html>