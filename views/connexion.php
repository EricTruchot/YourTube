<!-- PAGE CONNEXION UTILISATEUR -->
<?php


if (empty($_SESSION['type']) || $_SESSION['type'] != 'user') {
?>
    <section class="connexion">
        <p>Connexion | <a href="./index.php?page=inscription">Inscription</a></p>
        <p class="restrict"><?php
                            if (isset($_SESSION['error'])) {
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            }
                            ?></p>
        <?php
        if (!empty($_SESSION['erreur'])) { ?>
            <p class="erreur"><?php echo $_SESSION['erreur']; ?></p>
        <?php
            unset($_SESSION['erreur']);
        }
        ?>
        <form action="index.php?page=verifuser" method="POST">
            <label><b>Email:</b></label>
            <input type="text" name="email" required>
            <label><b>Mot de passe:</b></label>
            <input type="password" name="mdp" required>
            <button type="submit">Connexion</button>
        </form>
    </section>
<?php
} elseif ((!empty($_SESSION['type']) && $_SESSION['type'] == 'user')) {
} ?>