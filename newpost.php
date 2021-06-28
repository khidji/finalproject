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
    if (!empty($_POST['article_title']) && !empty($_POST['article_content']) && !empty($_POST['categories'])){

        $article_title = htmlentities($_POST['article_title']);
        $article_content = htmlentities($_POST['article_content']);
        $article_category = htmlentities($_POST['categories']);
        $publication = $pdo->prepare('INSERT INTO posts (content, title, user, category_id) VALUES (?,?,?,?)');
        $publication->execute(array($article_content, $article_title, $user, $article_category));
        $error_article = 'votre article a bien été posté';
    } else {
        $error_article = 'veuillez remplir tous les champs';
    }
}


?>


<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

<main class="newpost_main">
    <div class="newpost_container">
        <form class="newpost_form" method="POST">
            <input type="text" name="article_title" placeholder= "Titre">
            <textarea name="article_content" placeholder="contenu de l'article"></textarea>
            <input type="file">
            <label for="categories">Choisi une catégorie</label>
            <select id="categories" name="categories">
                <option value="1">HTML</option>
                <option value="2">CSS</option>
                <option value="3">JavaScript</option>
                <option value="4">PHP</option>
                <option value="5">Autre</option>
            </select>
            <input class="button" type="submit" value="envoyer l'article">
        </form>
    </div>
</main>

<footer>&copy; J'ai besoin d'aide 2021</footer>


<br>
<?php if(isset($error_article)) {echo $error_article;} ?>

<?php include ('template/footer.php'); ?>

</html>