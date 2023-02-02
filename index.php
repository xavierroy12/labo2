<?php
session_start();

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
        getFormConnexion();
    }
    elseif ($_REQUEST['action'] == 'authentifier') {
        if (isset($_REQUEST['courriel']) && isset($_REQUEST['mdp'])) {
        require('controller/controllerUtilisateur.php');
        authentifier($_REQUEST['courriel'], $_REQUEST['mdp'] );
        }
        else{
            echo 'Erreur : no email or no password';
        }
    }
    elseif($_REQUEST['action'] == 'deconnexion'){
        require('controller/controllerUtilisateur.php');
        deconnexion();
    }

}
// Si pas de paramètre charge l'accueil
else {
    //Ajoute le controleur de Produit
    require('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}
