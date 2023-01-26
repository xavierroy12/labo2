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
        $_SESSION['courriel'] = $utilisateur->getCourriel();
        $_SESSION['role'] = $utilisateur->getRole_utilisateur();
        listproduit();
    }
    else{
        echo 'Erreur de connection';
        require('view/loginView.php');
    }
}
function deconnexion()
{
    session_destroy();
}

?>