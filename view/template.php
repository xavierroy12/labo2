<?php
//Débogage afficher ce qui est reçu en paramètres
echo "----------------------------<br/>";
echo "Paramètres reçus:<br/><pre>";
print_r($_REQUEST);
echo "</pre>----------------------------<br/>";
?>


<?php $baseURL = "/mvc/"?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
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