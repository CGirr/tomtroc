<?php

?>

<section class="login-container">
    <div class="login-form-container">
        <h1>Connexion</h1>
        <div>
            <form action="index.php?action=login" method="post">
                <div>
                    <label for="email" class="inter-text">Adresse email</label>
                    <input type="email" name="email" id="email" required class="inter-text">
                </div>
                <div>
                    <label for="password" class="inter-text">Mot de passe</label>
                    <input type="password" name="password" id="password" required class="inter-text">
                </div>
                <button class="submit green-button">Se connecter</button>
            </form>
            <div>
                <p class="inter-text dark-grey-text">Pas de compte ? <a class="submit" href="index.php?action=register">Inscrivez-vous</a></p>
            </div>
        </div>
    </div>
    <div>
        <img src="./images/marialaura-gionfriddo.png" alt="Image représentant une bibliothèque.">
    </div>
</section>