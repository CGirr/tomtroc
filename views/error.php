<?php
/** @var $errorCode */
?>

<section class="error-container" role="alert" aria-live="assertive">
    <h1>Oups !</h1>
    <p><?= Helpers::sanitize($errorMessage ?? "Une erreur est survenue.") ?></p>
    <a href="index.php?action=home">Retour à l'accueil</a>
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
    <?php endif; ?>
    <a href="https://storyset.com/web">Web illustrations by Storyset</a>
</section>
