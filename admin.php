<?php

session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/database/index.php';

$user = $_SESSION['user'];

if (($user['is_admin']) != 1) {
    header("Location: login.php");
}

$posts_admin = $pdo->query("SELECT * FROM posts ORDER BY id DESC");
$posts_admin = $posts_admin->fetchAll(); 

$users_admin = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users_admin = $users_admin->fetchAll(); 

 

?>

<!DOCTYPE html>
<html lang="en">

<?php include ('template/header.php'); ?>


		<main>
        <div class="choix">
            <a href="#users_admin" class="cta">
                <span>gérer les utilisateurs</span>
                <svg width="13px" height="10px" viewBox="0 0 13 10">
                    <path d="M1,5 L11,5"></path>
                    <polyline points="8 1 12 5 8 9"></polyline>
                </svg>
            </a>
            <a href="#posts_admin" class="cta">
            <span>gérer les posts</span>
            <svg width="13px" height="10px" viewBox="0 0 13 10">
                <path d="M1,5 L11,5"></path>
                <polyline points="8 1 12 5 8 9"></polyline>
            </svg>
        </a>

        </div>
            
        <section id="users_admin">
            <ul class="posts">
				<?php foreach ($users_admin as $u):  ?>
				<li class="li_admin"> 
                    <h3><?= $u['pseudo']?> </h3>		
                </li>

				<?php endforeach; ?>
            </ul>	

        </section>



        <section id="posts_admin">
        <ul class="posts">
				<?php foreach ($posts_admin as $a):  ?>
				<li class="li_admin"> 
				<h3><?= $a['title']?> </h3>
				<p> <?= substr(($a['content']), 0, 100).'...' ?> </p>
				<a href="article.php?id=<?= $a['id'] ?>"> voir l'article </a> || <a href="edit.php?edit=<?= $a['id']?>">modifier</a> || <a href="delete.php?delete=<?= $a['id']?>">supprimer</a>
		
                </li>

				<?php endforeach; ?>
			</ul>	
        </section>

		</main>

<?php include ('template/footer.php'); ?>


</html>