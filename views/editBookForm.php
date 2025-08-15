<?php
/** @var $book */
?>
<div class="edit-book">
    <a class="light-grey-text" href="index.php?action=account">
        <img src="./images/left-arrow.png" class="left-arrow" alt="flèche vers la gauche"/> retour
    </a>
    <h3>Modifier les information</h3>
    <section class="edit-book-container">
        <article class="edit-book-cover">
            <span class="light-grey-text">Photo</span>
            <img
                    src="<?= Helpers::sanitizeUrl($book['cover']) ?>"
                    alt="Couverture du livre <?= Helpers::sanitize($book['title']) ?>"
            >
            <a href="#">Modifier la photo</a>
        </article>
        <article>
            <form action="index.php?action=editBook" method="post" class="edit-book-form">
                <input type="hidden" name="id" value="<?= Helpers::sanitize($book['id']) ?>">
                <?php if (!empty($error)) : ?>
                    <div class="danger-text alert-danger">
                        <?= Helpers::sanitize($error) ?>
                    </div>
                <?php endif; ?>
               <label for="title" aria-label="hidden">Titre</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="inter-text"
                    value="<?= Helpers::sanitize($book['title']) ?>"
                >

                <label for="author" class="inter-text light-grey-text">Auteur</label>
                <input
                        type="text"
                        name="author"
                        id="author"
                        class="inter-text"
                        value="<?= Helpers::sanitize($book['author']) ?>"
                >

                <label for="description" class="inter-text light-grey-text">Commentaire</label>
                <textarea
                        name="description"
                        id="description"
                        class="inter-text"><?= Helpers::sanitize($book['description']) ?>
                </textarea>

                <label for="available" class="inter-text light-grey-text">Disponibilité</label>
                <select name="available" id="available" class="inter-text">
                    <option value="1" <?= ($book['available'] == 1 ? 'selected' : '') ?>>Disponible</option>
                    <option value="0" <?= ($book['available'] == 0 ? 'selected' : '') ?>>Non disponible</option>
                </select>
                <button class="submit green-button">Valider</button>
            </form>
            <div class="alert alert-success">
                <?= Helpers::sanitize($success ?? '') ?>
            </div>
        </article>
    </section>
</div>
