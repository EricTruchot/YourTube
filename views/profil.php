<!-- PAGE PROFIL -->
<?php
if (empty($_SESSION['type']) || $_SESSION['type'] != 'user') {
        ?>
        <p class="restrict">Vous n'etes pas connecté</p>
        <?php
} elseif ((!empty($_SESSION['type']) && $_SESSION['type'] == 'user')) {

        $modifPseudo = $user->pseudo;
        $modifEmail = $user->email;
?>

        <article class="profil">
                <div>                
                <p class="text1">PROFIL</p>
                </div>
                <p class="yes"><?php
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?></p>
                <div class="modif">
                       
                        <form action="index.php?page=modifUser" method="POST">
                        <p class="text-modif">Modifier mes informations:</p>
                                <p class="text-profil">Email:</p>
                                <input type="text" name="modifEmail" value="<?= $modifEmail; ?>">
                                <p class="text-profil">Pseudo:</p>
                                <input type="text" name="modifPseudo" value="<?= $modifPseudo; ?>">
                                <p class="text-profil">Mot de passe:</p>
                                <input type="password" name="modifMdp" require>
                                <button class="btn-modif" type="submit" name="submitModifuser">MODIFIER</button>
                        </form>
                </div>


        </article>

<?php } ?>