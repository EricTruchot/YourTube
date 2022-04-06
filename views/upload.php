<!-- UPLOAD CONTENU -->
<?php
if ((!empty($_SESSION['type']) && $_SESSION['type'] == 'user')) {
?>
    <!-- HTML -->
    <section class="connexion">
    <p>Upload:</p>
        <p class="restrict"><?php
                            if (isset($_SESSION['error'])) {
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            }
                            ?></p>
        <p class="yes"><?php
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?></p>

        <?php
        if (!empty($_SESSION['erreur'])) { ?>
            <p class="erreur"><?php echo $_SESSION['erreur']; ?></p>
        <?php
            unset($_SESSION['erreur']);
        }
        ?>
        <form action="./index.php?page=uploadP2" method="POST" enctype="multipart/form-data">
            <label><b>Titre</b></label>
            <input type="text" name="titre" required>

            <label><b>Description</b></label>
            <textarea id="description" name="description" rows="5" cols="33" required></textarea>
            <label><b>Fichier</b></label>
            <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" value="Enovyer" name="submit">

        </form>


    </section>

<?php } else {
?>
    <p>Vous n'etes pas connecté</p>
<?php
}

?>