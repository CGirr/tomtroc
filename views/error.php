<?php

?>

<section class="error-container" role="alert" aria-live="assertive">
    <h1>Erreur <?= Helpers::sanitize($errorCode ?? 500) ?></h1>
    <p><?= Helpers::sanitize($errorMessage ?? "Une erreur est survenue.") ?></p>
    <a href="index.php?action=home" class="error-link">Retour à l'accueil</a>
</section>