<!-- HEADER -->
<?php
$link = $_SERVER['HTTP_HOST']; //Recuperation du "nom" du localhost pour le reutiliser dans le lien

if (!isset($_SESSION)) {
    session_start(); // Debut session utilisateur
}
$title = basename($_SERVER['PHP_SELF']); // Recuperation du nom du fichier pour le metre dans le title
$title = rtrim($title, ".php");

//var_dump($_SESSION);
//var_dump($link);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/fonts/Futura-Light.otf">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li class="bleu">YourTube</li>
                <li><a href="http://<?= $link ?>/index.php?page=accueil&filterby=idContenu">Acceuil</a></li>
                <?php
                // Modification de la navbar en fonction de l'utilisateur
                if (!empty($_SESSION['type']) && $_SESSION['type'] == 'user') {
                    echo "<li><a href='http://" . $link . "/index.php?page=mesContenu'>Mes contenus</a></li>
                <li><a href='http://" . $link . "/index.php?page=profil'>Profil</a></li>
                <li><a href='http://" . $link . "/index.php?page=logout&filterby=idContenu'>Déconnexion</a></li>";
                } elseif (!isset($_SESSION['type'])) {
                    echo "<li><a href='http://" . $link . "/index.php?page=connexion'>Connexion</a></li>";
                }
                ?>
            </ul>
        </nav>
    </header>
    <main>