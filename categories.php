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

$selection = $pdo->query('SELECT p.id, p.content, p.title, c.id, c.name FROM posts AS p JOIN categories AS c ON p.category_id=c.id;');
$c = $selection->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<?php include ('template/header.php'); ?>

<main>
  
  <ul>
  <?php foreach ($c as $key => $value) { ?>
    <li class ="lien_categorie"> <a href="categorie.php?id=<?= $c['id'] ?>"> <?= $c['name']?> </a> </li>
    <?php } ?>
  </ul>

</main>
<?php include ('template/footer.php'); ?>


</html>