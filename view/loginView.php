<?php $title = 'login'?>

<div class="g-signin2" data-onsuccess="onSignIn"></div>


<?php ob_start(); ?>
<h1>Se connecter</h1>

<form action="index.php" method="post" class="login">

    <div>
        <label for="courriel">Courriel: </label>
        <input type="text" name="courriel" id="courriel">
        </div>
    <div>
        <label for="mdp"><?= _("mot de passe")?> </label>
        <input type="password" name="mdp" id="mdp">
    </div>
    <input type="checkbox" id="souvenir" name="souvenir" value="true">
    <label for="souvenir"> <?= _("Se souvenir de moi")?></label><br>
    <input type="hidden" name="action" value="authentifier">
    <div>
        <button type="submit"><?= _("Se connecter")?></button>
    </div>
</form>

<div id="g_id_onload"
         data-client_id="215318157623-4kbv6bvn6gp1ppdqq59a0v5sppeh9i4b.apps.googleusercontent.com"
         data-login_uri="http://localhost/mvc/connexion/"
         data-auto_prompt="false">
      </div>
      <div class="g_id_signin"
         data-type="standard"
         data-size="large"
         data-theme="outline"
         data-text="sign_in_with"
         data-shape="rectangular"
         data-logo_alignment="left">
      </div>


<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>