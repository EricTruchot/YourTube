<!-- PAGE MES CONTENU -->
<?php
if ((!empty($_SESSION['type']) && $_SESSION['type'] == 'user')) {
?>
    <article class="mesContenu">
        <section class="up">
            <div class="bandeau">
                <p class="text1">Mes contenus</p>
                <a class="text2" href="http://<?= $link ?>/index.php?page=uploadP1">Ajouter un contenu</a>
                <p class="yes"><?php
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?></p>
            </div>
        </section>
        <section class="down">
        <?php while ($row = $stmt2->fetch()) {
        ?>
           
                <div class="block">
                    <form action="index.php?page=deleteContenu" method="post">
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
                            <p class="info"><i class="fa-solid fa-user"></i>Créer le: <?= $row->date; ?></p>
                            <p class="desc"><?= $row->description; ?></p>
                            <input type="text" hidden name="idContenu" value="<?= $row->idContenu; ?>">
                            <input type="text" hidden name="contenu" value="<?= $row->contenu; ?>">
                            <button class="btn-delete" type="submit" name="delete">Supprimer</button>
                        </div>
                    </form>
                </div>
            

        <?php } ?>
        </section>
    </article>
<?php } else {
?>
    <p class="restrict">Vous n'etes pas connecté.</p>
<?php
}

?>