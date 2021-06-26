<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];


if (isset ($_POST['article_title'], $_POST['article_content'])) {
    if (!empty($_POST['article_title']) && !empty($_POST['article_content'])){

        $article_title = htmlentities($_POST['article_title']);
        $article_content = htmlentities($_POST['article_content']);
        $publication = $pdo->prepare('INSERT INTO posts (content, title, user) VALUES (?,?,?)');
        $publication->execute(array($article_content, $article_title, $user));
        $error_article = 'votre article a bien été posté';
    } else {
        $error_article = 'veuillez remplir tous les champs';
    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau post</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/newpost.css">
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
    <div class="newpost_container">
        <form class="newpost_form" method="POST">
            <input type="text" name="article_title" placeholder= "Titre">
            <textarea name="article_content" placeholder="contenu de l'article"></textarea>
            <input type="file">
            <label for="categories">Choisi une catégorie</label>
            <select id="categories" name="categories">
                <option value="HTML">HTML</option>
                <option value="CSS">CSS</option>
                <option value="JavaScript">JavaScript</option>
                <option value="PHP">PHP</option>
                <option value="Autre">Autre</option>
            </select>
            <input class="button" type="submit" value="envoyer l'article">
        </form>
    </div>
</main>

<footer>&copy; J'ai besoin d'aide 2021</footer>


<br>
<?php if(isset($error_article)) {echo $error_article;} ?>

    
</body>
</html>