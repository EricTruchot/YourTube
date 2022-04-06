<!-- PAGE CONTENU principal -->
<article class="contenu">
<p class="text1">ACCUEIL</p>
    <div class="filtre">
        <a href="/index.php?page=accueil&filterby=idCategorie">Filtrer par: Categorie</a>
        <a href="/index.php?page=accueil&filterby=Contenu.idUser">Filtrer par: Utilisateur</a>
        <a href="/index.php?page=accueil&filterby=date">Filtrer par: Date</a>
    </div>
    <?php while ($row = $stmt->fetch()) {
        $i = $row->idContenu;
    ?>
        <div class="block">
            <?php
            if ($row->idCategorie == 2) { ?>
                <div class="top-video">
                    <video controls>
                        <source src="<?= $row->contenu ?>" />
                    </video>
                </div>
            <?php
            } elseif ($row->idCategorie == 1) { ?>
        <div class="top-img">
        <img src="<?= $row->contenu; ?>" alt="">
        </div>
        
    <?php }
    ?>
    <div class="bot">
    <p class="titre"><?= $row->titre; ?></p>
    <hr>
    <p class="info"><i class="fa-solid fa-user"></i>Créer par <?= $row->pseudo; ?> le <?= $row->date; ?></p>
    <p class="desc"><?= $row->description; ?></p>
    </div>
    </div>


<?php } ?>
</article>