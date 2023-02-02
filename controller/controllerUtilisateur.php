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
function  authentificationGoogle($credential){
    require_once 'vendor/autoload.php';
    $client = new Google_Client(['client_id' => "215318157623-4kbv6bvn6gp1ppdqq59a0v5sppeh9i4b.apps.googleusercontent.com"]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($credential);
    if ($payload) {
    $userid = $payload['sub'];
    print_r($payload);
    $utilisateurManager = new UtilisateurManager();
    $userLoggedGoogle = $utilisateurManager->getUtilisateurParCourriel($payload['email']);
    if(isset($userLoggedGoogle)){
        echo 'connected already existed congrats';
    }
    else{
        $info = [
            "courriel" => $payload["email"],
            "nom" => $payload["family_name"],
            "prenom" => $payload["given_name"]
        ];
       
        $utilisateurManager->addUtilisateur($info);
    }
    listProduits();
    }
    else {
    echo 'badPenis';
    }
}

?>