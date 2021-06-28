<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];

if(isset($_GET['id']) && !empty($_GET['id'])){
    $get_id = htmlentities($_GET['id']);
    $articles = $pdo->prepare('SELECT * FROM posts WHERE category_id = ?');
    $articles->execute(array($get_id));
    $article = $articles->fetch();
    $title = $article['title'];

} else {
    header("Location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

<main>


    <ul>
        <?php while ($a = $articles->fetch()) { ?>
        <li class ="lien_article"> <a href="article.php?id=<?= $a['id'] ?>"> <?= $a['title']?> </a> </li>
        <?php } ?>
    </ul>



</main>

<?php include ('template/footer.php'); ?>

</html>