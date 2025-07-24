<?php

?>
<section class="my-account">
    <h1>Mon compte</h1>
    <div class="my-account-container">
        <article>
            <div>
                <div class="profile-block">
                    <img src="<?= Helpers::sanitize($user->getProfilePicture()) ?>" alt="Photo de profil de l'utilisateur">
                    <a href="#" class="inter-text light-grey-text">modifier</a>
                </div>
                <div class="line"></div>
                <h3><?= Helpers::sanitize($user->getLogin()) ?></h3>
                <div>
                    Membre depuis **
                </div>
                <div>
                    Bibliothèque
                </div>
            </div>
        </article>
        <article>
            <h4>Vos informations personnelles</h4>
            <div>
                <form action="index.php?action=" method="post">
                    <div>
                        <label for="login" class="inter-text">Pseudo</label>
                        <input type="text" name="login" id="login" class="inter-text" placeholder="<?= Helpers::sanitize($user->getLogin()) ?>">
                    </div>
                    <div>
                        <label for="email" class="inter-text">Adresse email</label>
                        <input type="email" name="email" id="email" class="inter-text" placeholder="<?= Helpers::sanitize($user->getEmail()) ?>">
                    </div>
                    <div>
                        <label for="password" class="inter-text">Mot de passe</label>
                        <input type="password" name="password" id="password" class="inter-text" placeholder="•••••••••">
                    </div>
                    <button class="submit dark-grey-button">Enregistrer</button>
                </form>
            </div>
        </article>
    </div>
</section>



