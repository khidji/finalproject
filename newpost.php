<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];
$target_dir = "assets/images/bdd/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));



if (isset ($_POST['article_title'], $_POST['article_content'])) {
       
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
        }
    }

    if (!empty($_POST['article_title']) && !empty($_POST['article_content']) && !empty($_POST['categories'])){
        $article_title = htmlentities($_POST['article_title']);
        $article_content = htmlentities($_POST['article_content']);
        $article_category = htmlentities($_POST['categories']);
        
        $publication = $pdo->prepare('INSERT INTO posts (content, title, user, category_id, image_url) VALUES (?,?,?,?,?)');
        $publication->execute(array($article_content, $article_title, $user['pseudo'], $article_category, $target_file));
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
        <form class="newpost_form" method="POST" enctype="multipart/form-data">
            <input type="text" name="article_title" placeholder= "Titre">
            <textarea name="article_content" placeholder="contenu de l'article"></textarea>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <label for="categories">Choisi une catégorie</label>
            <select id="categories" name="categories">
                <option value="1">HTML</option>
                <option value="2">CSS</option>
                <option value="3">JavaScript</option>
                <option value="4">PHP</option>
                <option value="5">Autre</option>
            </select>
            <input class="button" type="submit" name="submit" value="envoyer l'article">
        </form>
        <?php if(isset($error_article)) {echo $error_article;} ?>
    </div>
</main>

<footer>&copy; J'ai besoin d'aide 2021</footer>


<br>

<?php include ('template/footer.php'); ?>

</html>