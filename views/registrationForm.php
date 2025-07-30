<?php

?>

<section class="login-container">
    <div class="login-form-container">
        <h1>Inscription</h1>
        <div>
            <form action="index.php?action=addUser" method="post">
                <?php if (!empty($error)) : ?>
                    <div class="danger-text alert-danger"><?= Helpers::sanitize($error) ?></div>
                <?php endif; ?>
                <div>
                    <label for="login" class="inter-text">Pseudo</label>
                    <input type="text" name="login" id="login" class="inter-text">
                </div>
                <div>
                    <label for="email" class="inter-text">Adresse email</label>
                    <input type="email" name="email" id="email" class="inter-text">
                </div>
                <div>
                    <label for="password" class="inter-text">Mot de passe</label>
                    <input type="password" name="password" id="password" class="inter-text">
                </div>
                <button class="submit green-button button-text">S'inscrire</button>
            </form>
            <div>
                <p class="inter-text dark-grey-text">
                    Déjà inscrit ?
                    <a class="submit" href="index.php?action=connectionForm">
                        Connectez-vous
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div>
        <img src="./images/marialaura-gionfriddo.png" alt="Image représentant une bibliothèque.">
    </div>
</section>