<?php

?>
<div class="edit-book">
    <a class="light-grey-text" href="index.php?action=account">
        <img src="./images/left-arrow.png" class="left-arrow" alt="flèche vers la gauche"/> retour
    </a>
    <h3>Ajouter un livre</h3>
    <section class="edit-book-container">
        <article>
            <form action="index.php?action=insertBook" method="post" class="edit-book-form" enctype="multipart/form-data">
                <?php if (!empty($error)) : ?>
                    <div class="danger-text alert-danger">
                        <?= Helpers::sanitize($error) ?>
                    </div>
                <?php endif; ?>

                <label for="cover" class="inter-text light-grey-text">Couverture du livre</label>
                <input
                    type="file"
                    name="cover"
                    id="cover"
                    class="inter-text image-upload"
                >

                <label for="title" class="inter-text light-grey-text">Titre</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    class="inter-text"
                >

                <label for="author" class="inter-text light-grey-text">Auteur</label>
                <input
                    type="text"
                    name="author"
                    id="author"
                    class="inter-text"
                >

                <label for="description" class="inter-text light-grey-text">Commentaire</label>
                <textarea
                    name="description"
                    id="description"
                    class="inter-text">
                </textarea>

                <label for="available" class="inter-text light-grey-text">Disponibilité</label>
                <select name="available" id="available" class="inter-text">
                    <option value="1" >Disponible</option>
                    <option value="0" >Non disponible</option>
                </select>
                <button class="submit green-button">Valider</button>
            </form>
        </article>
    </section>
</div>
