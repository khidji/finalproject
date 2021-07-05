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
    $article = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
    $article->execute(array($get_id));

    if($article->rowCount() == 1) {
        $article = $article->fetch();
        $title = $article['title'];
        $content = $article['content'];
        $image = $article['image_url'];
    } else {
        die ('Cet article n\'existe pas !');
    }

} else {
    header("Location: index.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

<main>
    <h1 class="article_titre"><?= $title ?></h1>
    <p class="article_content"><?= $content ?></p>
    <img class="article_img" src="<?php echo $image; ?>">
</main>

<?php include ('template/footer.php'); ?>

</html>