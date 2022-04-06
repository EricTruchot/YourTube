<?php
require_once("model/userModel.php");

function showConnexion()
{

    ob_start();
    include_once("header.php");
    require_once("views/connexion.php");
    include_once("footer.php");
    $content = ob_get_clean();
    return $content;
}

function userVerif()
{
    getConnexion();
}

function showMesContenu()
{
    $stmt2 = getMesContenu();
    ob_start();
    include_once("header.php");
    require_once("views/mesContenu.php");
    include_once("footer.php");
    $content = ob_get_clean();
    return $content;
}
function showInscription()
{
    ob_start();
    include_once("header.php");
    require_once("views/inscription.php");
    include_once("footer.php");
    $content = ob_get_clean();
    return $content;
}

function showUpload()
{
    $uploadP1 = getUploadP1();
    ob_start();
    include_once("header.php");
    require_once("views/upload.php");
    include_once("footer.php");
    $content = ob_get_clean();
    return $content;
}

function showUser()
    {
$user = getUser();
ob_start();
include_once("header.php");
require_once("views/profil.php");
include_once("footer.php");
$content = ob_get_clean();
return $content;
    }

