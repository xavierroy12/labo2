<?php $title = 'Inscription'?>
<?php ob_start(); ?>
<h1>Se connecter</h1>

<form action="index.php" method="post" class="login">
<div>
        <label for="prenom">Prenom: </label>
        <input type="text" name="prenom" id="prenom" required>
    </div>
    <div>
        <label for="nom">Nom: </label>
        <input type="text" name="nom" id="nom" required>
    </div>
    <div>
        <label for="courriel">Courriel: </label>
        <input type="text" name="courriel" id="courriel" required>
    </div>
    <div>
        <label for="mdp">Mot de passe: </label>
        <input type="password" name="mdp" id="mdp" required>
    </div>
    <input type="hidden" name="action" value="inscription">
    <div>
        <button type="submit">S'inscrire</button>
    </div>
</form>




<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>