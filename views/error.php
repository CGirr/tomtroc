<?php
/** @var $errorCode */
?>

<section class="error-container" role="alert" aria-live="assertive">
    <div class="error-text">
        <h1>Oups !</h1>
        <h3><?= Helpers::sanitize($errorMessage ?? "Une erreur est survenue.") ?></h3>
        <a href="index.php?action=home">Retour à l'accueil</a>
    </div>
    <div class="error-img">
        <?php if (Helpers::sanitize($errorCode == 404)): ?>
            <img
                    src ="./images/404.svg"
                    alt="Erreur 404"
            >
        <?php elseif (Helpers::sanitize($errorCode == 403)): ?>
            <img
                    src="./images/403.svg"
                    alt="Erreur 403"
            >
        <?php elseif (Helpers::sanitize($errorCode == 500)): ?>
            <img
                    src="./images/500.svg"
                    alt="Erreur 500"
            >
        <?php endif; ?>
        <a href="https://storyset.com/web" class="small-text">Web illustrations by Storyset</a>
    </div>
</section>
