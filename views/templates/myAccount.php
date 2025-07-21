<?php

?>

<h1>Mon compte</h1>
<img src="<?= Helpers::sanitize($user->getProfilePicture()) ?>">
<?= Helpers::sanitize($user->getLogin()) ?>

