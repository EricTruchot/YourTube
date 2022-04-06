<?php
require_once("model/contenuModel.php");

function showArticlePage()
{

    $stmt = getAllArticle();
    ob_start();
    include_once("header.php");
    require_once("views/contenu.php");
    include_once("footer.php");
    $content = ob_get_clean();
    return $content;
}



