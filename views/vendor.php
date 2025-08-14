<?php
/**
 * @var $accountData
 * @var $availableBooks
 */
?>
<div class="public-account-container">
    <section class="vendor-info-block">
        <img
                class="vendor-profile-picture"
                src="<?= Helpers::sanitizeUrl($accountData['profilePicture']) ?>"
                alt="Image de profil de <?= Helpers::sanitize($accountData['login']) ?>"
        >
        <div class="line-250"></div>
        <h4>
            <?= Helpers::sanitize($accountData['login']) ?>
        </h4>
        <div class="light-grey-text inter-text member-since">
            Membre depuis <?= Helpers::sanitize($accountData['registeredSince']) ?>
        </div>
        <div class="small-text library">
            Bibliothèque
        </div>
        <div class="inter-text book-icon">
            <img src="./images/book-icon.png" alt="icône représentant un livre">
            <?= Helpers::sanitize($accountData['numberOfBooks']) ?> livres
        </div>
        <button class="dark-grey-button button-text">
            Écrire un message
        </button>
    </section>
    <section class="vendor-library-block">
        <table id="vendor-library">
            <thead class="small-text">
            <tr>
                <th>PHOTO</th>
                <th>TITRE</th>
                <th>AUTEUR</th>
                <th>DESCRIPTION</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($availableBooks as $book): ?>
            <tr>
                <td>
                    <img src="<?= Helpers::sanitizeUrl($book['cover']) ?>" alt="couverture du livre">
                </td>
                <td><?= Helpers::sanitize($book['title']) ?></td>
                <td><?= Helpers::sanitize($book['author']) ?></td>
                <td class="italic-text">
                    <?= Helpers::sanitize(
                        mb_strimwidth($book['description'], 0, 85, "...")
                    ) ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</div>
