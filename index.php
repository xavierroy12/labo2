<?php
session_start();
define('REMEMBER_ME_COOKIE_DURATION', (86400 * 30));

//Débogage afficher ce qui est reçu en paramètres
//echo "----------------------------<br/>";
//echo "Paramètres reçus:<br/><pre>";
///print_r($_REQUEST);
//echo "</pre>----------------------------<br/>";

//Est-ce qu'un paramètre action est présent
if (isset($_REQUEST['action'])) {

    //Est-ce que l'action demandée est la liste des produits
    if ($_REQUEST['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits();
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    elseif ($_REQUEST['action'] == 'produit') {
        
        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($_REQUEST['id']);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    } 
    elseif ($_REQUEST['action'] == 'categories') {
        require('controller/controllerCategorie.php');
        listCategories();
    }
    elseif($_REQUEST['action'] == 'produitscategories') {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit

            listProduitsCategorie($_REQUEST['id']);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    }
    elseif(isset($_REQUEST["credential"])){
        require('controller/controllerUtilisateur.php');
        authentificationGoogle($_REQUEST["credential"]);
    }
    elseif ($_REQUEST['action'] == 'connexion') {
        require('controller/controllerUtilisateur.php');

        
        if (isset($_SESSION['courriel'])) {
            header('refresh: 0; url = index.php');
            exit;
        }
        
        if (isset($_COOKIE['remember_me'])) {
            $cookieValuesArray = json_decode($_COOKIE['remember_me'], true);

            if (authentifier_autologin($cookieValuesArray['user_id'],$cookieValuesArray['courriel'], $cookieValuesArray['token'])) {
                header('refresh: 0; url = index.php');
                exit;
            }
        }
        getFormConnexion(); 
    }
    elseif ($_REQUEST['action'] == 'authentifier') {
        if (isset($_REQUEST['courriel']) && isset($_REQUEST['mdp'])) {
        require('controller/controllerUtilisateur.php');
        if(!isset($_REQUEST['souvenir'])){
            $_REQUEST['souvenir'] = false;
        }

        authentifier($_REQUEST['courriel'], $_REQUEST['mdp'], $_REQUEST['souvenir'] );
        }
        else{
            echo 'Erreur : no email or no password';
        }
    }
    elseif($_REQUEST['action'] == 'deconnexion'){
        require('controller/controllerUtilisateur.php');
        deconnexion();
    }
    elseif ($_REQUEST['action'] == 'register'){

        require('controller/controllerUtilisateur.php');
        registerView();
    }
    elseif($_REQUEST['action'] == 'inscription'){
        require('controller/controllerUtilisateur.php');
        if (isset($_REQUEST['prenom']) && isset($_REQUEST['nom']) && isset($_REQUEST['mdp']) && isset($_REQUEST['courriel'])) {
            registerVerif($_REQUEST);
        }
    }
    elseif($_REQUEST['action'] == 'validation'){
        require('controller/controllerUtilisateur.php');
        checkTokenInscription($_REQUEST['id'], $_REQUEST['token']);
    }


}
// Si pas de paramètre charge l'accueil
elseif(isset($_COOKIE['remember_me'])){
    require('controller/controllerUtilisateur.php');
    $cookieValuesArray = json_decode($_COOKIE['remember_me'], true);

    if (authentifier_autologin($cookieValuesArray['user_id'],$cookieValuesArray['courriel'], $cookieValuesArray['token'])) {
        listProduits();
    }
}

else {
    //Ajoute le controleur de Produit
    require('controller/controllerAccueil.php');


    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}
