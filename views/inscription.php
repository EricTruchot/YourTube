<!-- PAGE INSCRIPTION UTILISATEUR -->
<?php
if (empty($_SESSION['type']) || $_SESSION['type'] != 'user') {
?>

<section class="connexion">
    <p><a href="../index.php?page=connexion">Connexion</a> | Inscription</p>
    <p class="restrict"><?php
                            if (isset($_SESSION['error'])) {
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            }
                            ?></p>
    <form action="index.php?page=inscrUser" method="POST">
        <label><b>Email:</b></label>
        <input type="text" name="email" required>
        <label><b>Pseudo:</b></label>
        <input type="text" name="pseudo" required>
        <label><b>Mot de passe:</b></label>
        <input type="password" name="mdp" required>
        <button type="submit" name="submitBtn">Inscription</button>
    </form>
</section>

<?php
} elseif ((!empty($_SESSION['type']) && $_SESSION['type'] == 'user')) {
    ?>
<p class="restrict">Vous etes deja connecté</p>

   <?php } ?>
