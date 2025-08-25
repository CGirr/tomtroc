<section class="login-container">
    <div class="login-form-container">
        <h1>Connexion</h1>
        <form method="post" action="index.php?action=login" novalidate>
            <?php if (!empty($error)) : ?>
                <div class="danger-text alert-danger" role="alert" aria-live="assertive">
                    <?= Helpers::sanitize($error) ?>
                </div>
            <?php endif; ?>

            <div>
                <label for="email" class="inter-text">Adresse email</label>
                <input
                        type="email"
                        name="email"
                        id="email"
                        class="inter-text"
                        required
                        autocomplete="email"
                >
            </div>

            <div>
                <label for="password" class="inter-text">Mot de passe</label>
                <input
                        type="password"
                        name="password"
                        id="password"
                        class="inter-text"
                        required
                        autocomplete="current-password"
                >
            </div>

            <button class="submit green-button button-text" type="submit">Se connecter</button>
        </form>

        <p class="inter-text dark-grey-text">
            Pas de compte ?
            <a class="submit a-login" href="index.php?action=register">Inscrivez-vous</a>
        </p>
    </div>

    <div>
        <img src="./images/marialaura-gionfriddo.png" alt="Image représentant une bibliothèque.">
    </div>
</section>
