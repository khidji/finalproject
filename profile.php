<?php

session_start();

// on vient inclure l'autoload de composer pour avoir accès au chargement automatiques des class (perso/externe)
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';



// si l'utilisateur n'est pas connecté on le renvoie vers le login
if (!isset($_SESSION['user'])) {
  header("Location: connexion/login.php");
}

$user = $_SESSION['user'];


$get_pseudo = htmlentities($user['pseudo']);
$user_post = $pdo->prepare('SELECT * FROM posts WHERE user = ? ORDER BY id DESC');
$user_post->execute(array($get_pseudo));

if($user_post->rowCount() != 0) {
	$user_post = $user_post->fetchAll(PDO::FETCH_OBJ);

} 


?>

<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>

		<main>
			<h1>Bienvenue
				<?=$user['first_name'];?>
			</h1>
			<p>Tu es sur ton compte voici tes informations:
			Tu t'appelles 				
			<?=$user['first_name'];?> <?=$user['last_name'];?> !
			Ton pseudo est <?=$user['pseudo'];?>.
			Tu habites en <?=$user['country'];?> à cette adresse : <?=$user['address'];?>.
			Ton numéro de téléphone est <?=$user['phone'];?>. 
			Ton email est <?=$user['email'];?>.
			</p>
			<h1>T'as besoin d'aide ? </h1>
			<a href="newpost.php">
			<button > Créer un post</button>
			</a>
			<p>Voici les articles que tu as posté :   insérer articles</p>
			<?php foreach($user_post as $post) { ?>
			<h1><a href="article.php?id=<?= $post->id ?>"><?= htmlentities($post->title) ?> </a> || <a href="edit.php?edit=<?= $post->id?>">modifier</a> || <a href="">supprimer</a></h1>
			<?php } ?>
		</main>

<?php include ('template/footer.php'); ?>

	</body>

</html>