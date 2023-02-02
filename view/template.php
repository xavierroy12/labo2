<?php
    echo '----------------------------<br />
          Paramètres reçus :<br />
          $_REQUEST :<br />
          <pre>';

    print_r($_REQUEST);
    
    echo '</pre>
          $_SESSION :<br />
          <pre>';
    print_r($_SESSION);
    echo '</pre>
          $_COOKIE :<br />
          <pre>';

    print_r($_COOKIE);


    echo '</pre>----------------------------<br />';
?>



<?php $baseURL = "/mvc/"?>
<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8" />
        <meta name="google-signin-client_id" content=" 215318157623-4kbv6bvn6gp1ppdqq59a0v5sppeh9i4b.apps.googleusercontent.com">
        <meta name="referrer" content="no-referrer-when-downgrade" />
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <title><?= $title ?></title>
        <link href="<?= $baseURL;?>inc/css/style.css" rel="stylesheet" /> 
    </head>
        
    <body>
        <?php if(isset($_SESSION['courriel']))
        echo 'bienvenue '. $_SESSION['courriel'];
        ?>
        <nav>
            <ul>
                <li><a href="<?= $baseURL;?>index.php">Accueil</a></li>
                <li><a href="<?= $baseURL;?>produits">Les produits</a></li>
                <li><a href="<?= $baseURL;?>categories">Les categories</a></li>
                <li><a href="<?= $baseURL;?>register">S'inscrire</a></li>
                
                <?php if(isset($_SESSION['courriel'])) : ?>
                    <li><a href="<?= $baseURL;?>deconnexion">Se deconnecter</a></li>
                <?php else : ?>
                    <li><a href="<?= $baseURL;?>connexion">Se Connecter</a></li>
                <?php endif; ?>

            </ul>
        </nav>
        <?= $content ?>
    </body>
</html>