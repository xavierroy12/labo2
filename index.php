<?php 
session_start();


if (!isset($_SESSION['language'])) {
    $_SESSION['language'] = 'fr'; // Set French as default language 
  }
else{
    if(isset($_REQUEST['lang']))
    $_SESSION['language'] = $_REQUEST['lang'];

}
/* Importation de la librairie "gettext" (en supposant que
   les fichiers de la librairie ont été placés dans un dossier
   "gettext" lui-même situé à la racine du site Web). */
require_once './inc/lib/gettext.inc';

// Le nom des fichiers de traduction ".mo" (sans l'extension)
define('TRANSLATE_FILENAME', 'traduction');

/* La variable $langue pourra toujours être modifiée en fonction
   du choix qu'aura fait l'utilisateur (par exemple, par le biais
   d'une valeur enregistrée dans la session PHP). Pour le moment,
   cette variable est simplement forcée à 'fr_ca'. */
   
if(isset($_SESSION['language']) && $_SESSION['language'] === 'en')
$langue = 'en_ca';
elseif((isset($_SESSION['language']) && $_SESSION['language'] === 'pt'))
$langue = 'pt_br';
else
$langue = 'fr';
T_setlocale(LC_MESSAGES, $langue);

/* On associe le nom des fichiers de traduction ".mo" au chemin
   complet permettant d'y accéder (ici, il s'agit de la racine
   de notre site Web concaténée au dossier 'locale'). */
bindtextdomain(TRANSLATE_FILENAME, (realpath('./') . '\\locale\\'));

// L'encodage des fichiers de traduction ".mo" est établi ici.
if (function_exists('bind_textdomain_codeset'))
    bind_textdomain_codeset(TRANSLATE_FILENAME, 'UTF-8');

/* Le bon fichier de traduction ".mo" tout dépendant de la
   langue choisie par l'utilisateur est automatiquement
   appliqué ici. */
textdomain(TRANSLATE_FILENAME);


   
    /* Pour gérer le pluriel des mots, une variable doit d'abord être
       déclarée. Celle-ci contiendra un nombre qui déterminera si un
       quelconque mot doit être mis au singulier ou au pluriel. */
    $qt = 3;
   
    /* La fonction ngettext() permet de gérer le singulier et le
       pluriel d'un mot :
       
       - Premier argument   => Version du mot au singulier
       - Deuxième argument  => Version du mot au pluriel
       - Troisième argument => Un nombre (la variable précédemment
                               créée) qui permet d'indiquer quelle
                               version prendre
       
       La fonction sprintf() permet, quant à elle, de formater une
       chaîne de caractères en remplaçant, dans l'exemple ci-dessous,
       le paramètre %d par le nombre contenu dans la variable $qt. */



//Fin du test de traduction et debut de index.php


$infoProduit = json_decode(file_get_contents('php://input'), true);
define('REMEMBER_ME_COOKIE_DURATION', (86400 * 30));

if(isset($infoProduit['action']) && $infoProduit['action'] === 'addProduit'){
    http_response_code(200);
    $_REQUEST['action'] = 'none';
    require('controller/controllerProduit.php');
    $lastinsertid = insertProduit($infoProduit['produit'],$infoProduit['categorie'],$infoProduit['description']);
  

   
    exit;
    }
else if(isset($infoProduit['action']) && $infoProduit['action'] === 'deleteProduit'){
    http_response_code(200);
    $_REQUEST['action'] = 'none';
    require('controller/controllerProduit.php');
    deleteProduit($infoProduit['id']);

    exit;
}
else if(isset($infoProduit['action'])){
    http_response_code(400);
}
    


//Est-ce qu'un paramètre action est présent
if (isset($_REQUEST['action'])) {
    if($_REQUEST['action'] == "testAjax"){
        print_r($_REQUEST);
        exit;
    }

    //Est-ce que l'action demandée est la liste des produits
    else if ($_REQUEST['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits(FALSE);
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    elseif ($_REQUEST['action'] == 'produit') {
        
        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($_REQUEST['id'],FALSE);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo _('Erreur : aucun identifiant de produit envoyé');
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
            echo _('Erreur : aucun identifiant de produit envoyé');
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
            echo _('Erreur : pas de courriel ou de mot de passe');
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
    elseif(isset($infoProduit['action']) && $infoProduit['action'] === 'addProduit'){
        require('controller/controllerProduit.php');
        http_response_code(200);
        insertProduit($infoProduit['produit'],$infoProduit['categorie'],$infoProduit['description']);
        exit;
    }
    elseif($_REQUEST['action'] == 'deleteProduit'){
        require('controller/controllerProduit.php');
        deleteProduit($_REQUEST['id']);
        
    }
    elseif($_REQUEST['action'] == 'achat'){
        require('controller/controllerProduit.php');
        deleteProduit($_REQUEST['id']);
        
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
   // Ajoute le controleur de Produit
   require('controller/controllerAccueil.php');


    //Appel la fonction listProduits contenu dans le controleur de Produit
   listProduits();
}
