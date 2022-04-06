<?php

require_once("controller/contenuController.php");
require_once("controller/userController.php");

if (isset($_GET['page'])) {
    switch ($_GET['page']) {

        case 'logout':
            logout();
            $content = showArticlePage();
            break;
        case 'accueil':
            $content = showArticlePage();
            break;
        case 'connexion':
            $content = showConnexion();
            break;
        case 'verifuser':
            userVerif();
            $content = showMesContenu();
            break;
        case 'inscription':
            $content = showInscription();
            break;
        case 'inscrUser':
            getInscription();
            $content = showArticlePage();
            break;
        case 'mesContenu':
            $content = showMesContenu();
            break;
        case 'uploadP1':
            $content = showUpload();
            break;
        case 'uploadP2':
            getUploadP2();
            $content = showMesContenu();
            break;
        case 'deleteContenu':
            getDeleteContenu();
            $content = showMesContenu();
            break;
        case 'profil':
            $content = showUser();
            break;
        case 'modifUser':
            getModifUser();
            $content = showUser();
            break;
        default:
            $content = showArticlePage();
    }
} else {
    $content = showArticlePage();
}

echo $content;
