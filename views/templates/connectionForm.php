<?php

?>

<h1>Connexion</h1>
<div class="">
    <form action="index.php?action=login" method="post" class="">
        <label for="email">Adresse email</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>
        <button class="submit green-button">Se connecter</button>
    </form>
</div>
<div>
    <p class="inter-text dark-grey-text">Pas de compte ? <a class="submit" href="index.php?action=register">Inscrivez-vous</a></p>
</div>