<?php


function dbConnect1() // CONNEXION A LA BDD
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

function logout()
{
    session_start();
    session_unset();
    session_destroy();
}

function getConnexion()
{
    $pdo = dbConnect1();

    if (
        filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)
        && htmlspecialchars(filter_input(INPUT_POST, "mdp"))
    ) {

        $userEmail = $_POST['email'];
        $userMdp = $_POST['mdp'];

        if (isset($userEmail) && isset($userMdp)) {


            $requete = $pdo->prepare("SELECT email, mdp, idUser, pseudo, type
                                      FROM User 
                                      WHERE email = :email");

            $requete->execute(["email" => $userEmail]);

            $row = $requete->fetchAll();

            $verifPwd = password_verify($userMdp, $row[0]->mdp);

            if ($verifPwd == true && ($userEmail == $row[0]->email)) {
                session_start();
                $_SESSION['email'] = $userEmail;
                $_SESSION['idUser'] = $row[0]->idUser;
                $_SESSION['type'] = $row[0]->type;
                $_SESSION['pseudo'] = $row[0]->pseudo;
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['error'] = 'Erreur de mot de passe';
                header("Location: index.php?page=connexion");
                exit;
            }
        }
    } else {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['error'] = 'Entrer des identifiants valide';
        header("Location: index.php?page=connexion");
        exit;
    }
}


function getInscription()
{
    $pdo = dbConnect1();

    if (
        filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)
        && htmlspecialchars(filter_input(INPUT_POST, "pseudo"))
        && htmlspecialchars(filter_input(INPUT_POST, "mdp"))
    ) {

        $userEmail = $_POST['email'];
        $userMdp = $_POST['mdp'];
        $userPseudo = $_POST['pseudo'];


        $option = ['cost' => 12,];
        $hash = password_hash($userMdp, PASSWORD_BCRYPT, $option);
        // prepare la requete (le ? sert a securié la requete avec le array() de la ligne suivante)
        $requete = $pdo->prepare("SELECT email, pseudo FROM User WHERE email = :email OR pseudo = :pseudo");
        // execution de la requete  
        $requete->execute(["email" => $userEmail, "pseudo" => $userPseudo]);
        /// transformer le retour en tableau 
        $row = $requete->fetchAll();
        // if ($row["email"] == $userEmail || $row["pseudo"] == $userPseudo) {
        if (!empty($row)) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['error'] = 'Email ou pseudo deja existant';
            header("Location: index.php?page=inscription");
            exit;
        } else {
            $reqInscription = $pdo->prepare("INSERT INTO User (idUser, email, mdp, pseudo, type) VALUES
            (DEFAULT, :email, :mdp, :pseudo, DEFAULT)");
            $reqInscription->execute(["email" => $userEmail, "pseudo" => $userPseudo, "mdp" => $hash]);
        }
    } else {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['error'] = 'Saisie invalide';
        header("Location: index.php?page=inscription");
        exit;
    }
}

function getMesContenu()
{
    $pdo = dbConnect1();
    if (!isset($_SESSION)) {
        session_start();
    }
    $idUser = $_SESSION['idUser'];
    $stmt2 = $pdo->query("SELECT idContenu, User.idUser, titre, contenu, description, date, pseudo, idCategorie
    FROM Contenu  
    JOIN User
         ON User.idUser = Contenu.idUser
         WHERE User.idUser = $idUser");

    return $stmt2;
}


function getUploadP1()
{
    $pdo = dbConnect1();
    $req = $pdo->query('SELECT idCategorie, categorie FROM Categorie');
    $uploadP1 = $req->fetchAll(PDO::FETCH_ASSOC);
    return $uploadP1;
}
function getUploadP2()
{
    session_start();
    $pdo = dbConnect1();
    if (
        htmlspecialchars(filter_input(INPUT_POST, "titre"))
        && htmlspecialchars(filter_input(INPUT_POST, "description"))
    ) {
        // PARTIE UPLOAD ============================================================================
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        //$fileName = $_FILES["fileToUpload"]["name"];
        $uploadOk = 1;
        $fileType = 0;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            // Allow certain file formats
            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif") {

                $uploadOk = 1;
                $fileType = 1;
            } elseif ($imageFileType == "mp4" || $imageFileType == "flv" || $imageFileType == "wmv" || $imageFileType == "mov") {

                $uploadOk = 1;
                $fileType = 2;
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['error'] = 'Fichier non supporter';
                $uploadOk = 0;
                header("Location: index.php?page=uploadP1");
                exit;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['error'] = 'Le fichier existe deja';
            $uploadOk = 0;
            header("Location: index.php?page=uploadP1");
            exit;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['error'] = 'Fichier trop volumineux';
            $uploadOk = 0;
            header("Location: index.php?page=uploadP1");
            exit;
        }


        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['error'] = "Le fichier n'a pas pu etre envoyer ";
            header("Location: index.php?page=uploadP1");
            exit;
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

                // echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['error'] = "Erreur denvoie";
                $uploadOk = 0;
                header("Location: index.php?page=uploadP1");
                exit;
                
            }
        }


        // PARTIE SQL    ============================================================================
        $addTitre = $_POST['titre'];
        $addDescription = $_POST['description'];
        // $addContenu = $_FILES["fileToUpload"]["name"];
        $addIdUser = $_SESSION['idUser'];

        // Commande SQL
        if ($uploadOk == 0) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['error'] = 'Erreur remplisage base de données';
            header("Location: index.php?page=uploadP1");
            exit;
            // if everything is ok, try to upload file
        } else {
            $reqUpload = $pdo->prepare("INSERT INTO Contenu (idContenu, titre, contenu, description, date, idUser, idCategorie) VALUES
            (DEFAULT, :titre, :contenu, :description, DEFAULT, :idUser, :menuCat)");
            $reqUpload->execute(["titre" => $addTitre, "contenu" => $target_file, "description" => $addDescription, "idUser" => $addIdUser, "menuCat" => $fileType]);
            $test = $reqUpload->errorInfo();
            $_SESSION["message"] = "Votre fichier a bien été envoyer";
            header("Location: index.php?page=uploadP1");
            exit;
        }
    } else {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['error'] = 'Saisie invalide';
        header("Location: index.php?page=uploadP1");
        exit;
    }
}
function getUser()
{
    $pdo = dbConnect1();
    if (!isset($_SESSION)) {
        session_start();
    }
    $req = $pdo->prepare('SELECT idUser, email, mdp, pseudo, type
                     FROM User 
                     WHERE idUser = :user');
    $req->execute(["user" => $_SESSION['idUser']]);
    $user = $req->fetch();

    return $user;
}
function getModifUser()
{
    $pdo = dbConnect1();
    session_start();
    if (
        filter_input(INPUT_POST, "modifEmail", FILTER_VALIDATE_EMAIL)
        && htmlspecialchars(filter_input(INPUT_POST, "modifPseudo"))
    ) {
        $modifPseudo = $_POST['modifPseudo'];
        $modifEmail = $_POST['modifEmail'];

        $reqModifUser = $pdo->prepare("UPDATE User SET pseudo = :pseudo, email = :email  WHERE idUser = :idUser");
        $reqModifUser->execute(["email" => $modifEmail, "pseudo" => $modifPseudo, "idUser" => $_SESSION['idUser']]);
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION["message"] = "Profil modifié";
        header("Location: index.php?page=profil");
        exit;
    }
}
