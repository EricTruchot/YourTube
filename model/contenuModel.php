<?php


function dbConnect() // CONNEXION A LA BDD
{
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "YourTube";

    // FONCTION DE CONNEXION A LA DB
    try {
        // DEFINITION DE LA CONNEXION (LOGIN UTILISATEUR ET NOM DE LA DB (avec les variables precedentes))
        $dsn = "mysql:host=" . $servername . ";dbname=" . $dbname;
        $pdo = new PDO($dsn, $username, $password);

        // catch: ATTRAPE LES ERREURS DE LA FONCTION try
    } catch (PDOException $e) {
        echo "Connexion a la DB echoué: " . $e->getMessage();
    }
    // setATTRIBUTE:  Configure un attribut PDO
    // ATTR_DEFAULT_FETCH_MODE: Définit le mode de récupération par défaut.
    // FETCH_OBJ: Récupère la prochaine ligne et la retourne en tant qu'objet
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    return $pdo;
}
// ====================================================================================================
// ====================================================================================================
function getAllArticle()
{
    if (
        filter_input(INPUT_GET, "filterby")
    ) {
        $filter = $_GET['filterby'];


        $pdo = dbConnect();
        $stmt = $pdo->query("SELECT idContenu, titre, contenu, description, date, pseudo, categorie, Contenu.idCategorie
                     FROM Contenu  
                     JOIN User
                         ON User.idUser = Contenu.idUser
                     JOIN Categorie
                         ON Categorie.idCategorie = Contenu.idCategorie
                         ORDER BY $filter DESC");

        return $stmt;
    }
    else {
        $pdo = dbConnect();
        $stmt = $pdo->query("SELECT idContenu, titre, contenu, description, date, pseudo, categorie, Contenu.idCategorie
                     FROM Contenu  
                     JOIN User
                         ON User.idUser = Contenu.idUser
                     JOIN Categorie
                         ON Categorie.idCategorie = Contenu.idCategorie
                         ORDER BY idContenu DESC");

        return $stmt;

    }
}
function getDeleteContenu()
{
    if (isset($_POST["delete"])) {
        $idContenu = $_POST['idContenu'];
        $contenu = $_POST['contenu'];
        $pdo = dbConnect();
        $req = "DELETE FROM Contenu WHERE idContenu = $idContenu";
        $pdo->query($req);
        unlink($contenu);
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["message"] = "Contenu supprimer";
        header("Location: index.php?page=mesContenu");
        exit;
    }
}
