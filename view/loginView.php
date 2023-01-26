<?php $title = 'login'?>



<?php ob_start(); ?>
<h1>Se connecter</h1>

<form action="index.php" method="post" class="login">

    <div>
        <label for="courriel">Courriel: </label>
        <input type="text" name="courriel" id="courriel">
        </div>
    <div>
        <label for="mdp">Mot de passe: </label>
        <input type="password" name="mdp" id="mdp">
    </div>
    <input type="checkbox" id="souvenir" name="souvenir" value="souvenir">
    <label for="souvenir"> Se souvenir de moi</label><br>
    <input type="hidden" name="action" value="authentifier">

    <div>
        <button type="submit">Se connecter</button>
    </div>
</form>


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>