<?php
?>
<span class="single-span small-text-10 weight-300 light-grey-text">Nos livres > <?= Helpers::sanitize($book['title']) ?></span>
<section class="single-container">
    <img src="<?= Helpers::sanitizeUrl($book['cover']) ?>" alt="Couverture du livre <?= Helpers::sanitize($book['title']) ?>">
    <article class="single-book-info">
        <h1><?= Helpers::sanitize($book['title']) ?></h1>
        <h4 class="light-grey-text">par <?= Helpers::sanitize($book['author']) ?></h4>
        <div class="line"></div>
        <span class="small-text">Description</span>
        <p>
            <?= nl2br(Helpers::sanitize($book['description'])) ?>
        </p>
        <span class="small-text">Propriétaire</span>
        <div class="vendor-block">
            <img src="<?= Helpers::sanitizeUrl($book['profile_picture']) ?>" alt="Photo de profil de l'utilisateur">
            <div><?= Helpers::sanitize($book['vendor']) ?></div>
        </div>
        <button class="green-button">
            Envoyer un message
        </button>
    </article>
</section>
