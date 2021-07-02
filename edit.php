<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];


if(isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_id = htmlentities($_GET['edit']);
    $edit_article = $pdo->prepare('SELECT * FROM posts WHERE id = ?');
    $edit_article->execute(array($edit_id));
    if($edit_article->rowCount() == 1) {
       $edit_article = $edit_article->fetch();
    } else {
       die('Erreur : l\'article n\'existe pas...');
    }
}

$target_file = null;

if (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
    $target_dir = "assets/images/bdd/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $error_article = "File is not an image.";
            $uploadOk = 0;
        }
        }

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error_article = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $error_article = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }}
}
     
    


    
if (isset ($_POST['article_title'], $_POST['article_content'])) {   
    if (!empty($_POST['article_title']) && !empty($_POST['article_content'])){
        $article_title = htmlentities($_POST['article_title']);
        $article_content = htmlentities($_POST['article_content']);

        $publication = $pdo->prepare("UPDATE posts SET content=?, title=?, image_url=? WHERE id = ?");
        $publication->execute(array($article_content, $article_title, $target_file, $edit_id));
        $error_article = 'votre article a bien été posté';
    } else {
        $error_article = 'veuillez remplir les champs obligatoires (titre et contenu)';
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

<main class="newpost_main">
    <div class="newpost_container">
        <form class="newpost_form" method="POST" enctype="multipart/form-data" action="article.php?id=<?= $a['id'] ?>">
            <input type="text" name="article_title" placeholder= "Titre" value = "<?= $edit_article['title']?>">
            <textarea name="article_content" placeholder="contenu de l'article"><?= $edit_article['content']?></textarea>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input class="button" type="submit" name="submit" value="envoyer l'article">
        </form>
        <?php if(isset($error_article)) {echo $error_article;} ?>
    </div>
</main>

<footer>&copy; J'ai besoin d'aide 2021</footer>


<br>

<?php include ('template/footer.php'); ?>

</html>