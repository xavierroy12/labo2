<?php

require('model/UtilisateurManager.php');
require('controllerAccueil.php');

function getFormConnexion()
{
    //$utilisateurManager = new UtilisateurManager();
   // $utilisateur = $utilisateurManager->getutilisateur();

    require('view/loginView.php');
}
function authentifier($courriel, $motPasse)
{
    $utilisateurManager = new UtilisateurManager();
    $utilisateur =  $utilisateurManager->verifAuthentification($courriel, $motPasse);
    if(isset($utilisateur)){
        $_SESSION['courriel'] = $utilisateur->get_Courriel();
        $_SESSION['role'] = $utilisateur->get_Role_utilisateur();
        listProduits();
       
    }
    else{
        echo 'Erreur de connection';
        require('view/loginView.php');
    }
}
function deconnexion()
{
    session_unset();
    session_destroy();
   
 
    echo 'Vous avez été déconnecter';
    listProduits();
}

?>