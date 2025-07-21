<?php

?>

<h1>Inscription</h1>
<div class="">
    <form action="index.php?action=addUser" method="post" class="">
        <label for="login">Pseudo</label>
        <input type="text" name="login" id="login" required>
        <label for="email">Adresse email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <button class="submit green-button">S'inscrire</button>
    </form>
</div>
<div>
    <p class="inter-text dark-grey-text">Déjà inscrit ? <a class="submit" href="index.php?action=connexion">Connectez-vous</a></p>
</div>