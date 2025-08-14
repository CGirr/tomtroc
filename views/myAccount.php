<?php
/** @var $profilePicture
 *  @var $login
 *  @var $registeredSince
 *  @var $numberOfBooks
 */
?>
<div class="account">
    <section class="my-account">
        <h3>Mon compte</h3>
        <div class="my-account-container">
            <article class="member-block-container">
                <div>
                    <div class="profile-block">
                        <img src="<?= Helpers::sanitizeUrl($profilePicture) ?>" alt="Photo de profil de l'utilisateur">
                        <a href="#" class="inter-text light-grey-text">modifier</a>
                    </div>
                    <div class="line-250"></div>
                    <div class="member-block">
                        <h4><?= Helpers::sanitize($login) ?></h4>
                        <div class="light-grey-text member-block-years">
                            Membre depuis <?= Helpers::sanitize($registeredSince) ?>
                        </div>
                        <div class="small-text library">
                            Bibliotheque
                        </div>
                        <div class="library">
                            <img src="./images/book-icon.png" alt="icône représentant un livre">
                                <?= Helpers::sanitize($numberOfBooks) ?> livres
                        </div>
                    </div>
                </div>
            </article>
            <article class="my-account-form-container">
                <h5>Vos informations personnelles</h5>
                <div>
                    <form action="index.php?action=account" method="post" class="my-account-form">
                        <?php if (!empty($error)) : ?>
                            <div class="danger-text alert-danger">
                                <?= Helpers::sanitize($error) ?>
                            </div>
                        <?php endif; ?>
                        <label for="email" class="inter-text light-grey-text">Adresse email</label>
                        <input
                                type="email"
                                name="email"
                                id="email"
                                class="inter-text"
                                value="<?= Helpers::sanitize($formData['email'] ?? '') ?>"
                        >

                        <label for="password" class="inter-text light-grey-text">Mot de passe</label>
                        <input
                                type="password"
                                name="password"
                                id="password"
                                class="inter-text"
                                placeholder="•••••••••"
                        >

                        <label for="login" class="inter-text light-grey-text">Pseudo</label>
                        <input
                                type="text"
                                name="login"
                                id="login"
                                class="inter-text"
                                value="<?= Helpers::sanitize($formData['login'] ?? '') ?>"
                        >

                        <button class="submit dark-grey-button">Enregistrer</button>
                    </form>
                </div>
            </article>
        </div>
    </section>
    <section>
        <?php if (empty($userBooks)) : ?>
            <h3 class="member-block">Aucun livre n'est encore enregistré.</h3>
        <?php else : ?>
            <table id="books">
                <thead class="small-text">
                <tr>
                    <th>PHOTO</th>
                    <th>TITRE</th>
                    <th>AUTEUR</th>
                    <th>DESCRIPTION</th>
                    <th>DISPONIBILITE</th>
                    <th>ACTION</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($userBooks as $book): ?>
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
                        <td>
                            <?php if ($book['available']): ?>
                                <span class="available">disponible</span>
                            <?php else: ?>
                                <span class="unavailable">non dispo.</span>
                            <?php endif; ?>
                        </td>
                        <td class="table-actions">
                            <a href="index.php?action=editBook&id=<?= Helpers::sanitize($book['id']) ?>">Éditer</a>
                            <form method="post" action="index.php?action=deleteBook"
                                  onsubmit="return confirm('Voulez-vous vraiment supprimer ce livre ?');">
                                <input type="hidden" name="id" value="<?= Helpers::sanitize($book['id']) ?>">
                                <button type="submit" class="danger-text">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</div>
