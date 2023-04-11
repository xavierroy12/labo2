<?php

require('model/UtilisateurManager.php');
require('controllerAccueil.php');

function getFormConnexion()
{
    //$utilisateurManager = new UtilisateurManager();
   // $utilisateur = $utilisateurManager->getutilisateur();

    require('view/loginView.php');
}
function authentifier($courriel, $motPasse, $remember)
{
    $utilisateurManager = new UtilisateurManager();
    $utilisateur =  $utilisateurManager->verifAuthentification($courriel, $motPasse);
    if(isset($utilisateur) && $utilisateur->get_est_actif() == 1){
        $_SESSION['courriel'] = $utilisateur->get_Courriel();
        $_SESSION['role'] = $utilisateur->get_Role_utilisateur();
//ici
        if($remember == 'true'){
            
            if($utilisateurManager->autoLoginSetactif($utilisateur->get_id_utilisateur(),$courriel)){
                echo 'autologin already exist, so not adding a new one';
               
            }
            else{
            $utilisateurManager->addAutoLogin($utilisateur->get_id_utilisateur(), $utilisateur->get_courriel());
            echo 'adding a new autologin in tbl autologin';
            }
        }
        listProduits();
       
    }
    else{
        echo 'Erreur de connection';
        require('view/loginView.php');
    }
}
function deconnexion()
{
    require_once("Util.php");
    $utilisateurManager = new UtilisateurManager();
    $utilisateurManager->autoLoginCheck();
    session_unset();
    session_destroy();
    if (isset($_COOKIE['remember_me'])) {
         $utili = new Util();
         $utili->clearAuthCookie();
    }
    echo 'Vous avez été déconnecter';
    listProduits();
}
function  authentificationGoogle($credential){
    require_once 'vendor/autoload.php';
    $client = new Google_Client(['client_id' => "215318157623-4kbv6bvn6gp1ppdqq59a0v5sppeh9i4b.apps.googleusercontent.com"]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($credential);
    if ($payload) {
    $userid = $payload['sub'];
    
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
    echo 'badConnect';
    }
}
function authentifier_autologin($idUser,string $courriel, string $randomToken) : bool {

    
    $utilisateurManager = new UtilisateurManager();

    /* La méthode verifier_autologin() doit être codée dans le gestionnaire
       "UtilisateurManager" (à vous de la coder) et doit valider que le
       "token" pour l'utilisateur donné existe dans la BD et est encore
       valide (il n'a pas expiré). Si la validation fonctionne, c'est-à-dire
       que le "token" existe en BD et est encore valide, on peut réactiver
       la session PHP. */
    if ($utilisateurManager->verifier_autologin($idUser, $randomToken)) {

        $utilisateur = $utilisateurManager->getUtilisateurParCourriel($courriel);
        
        $_SESSION['courriel'] = $courriel;
        $_SESSION['role'] = $utilisateur->get_role_utilisateur();
        echo'logged in by cookie autologger, Set the session variable from the cookie';
        return true;
    }
    
    /* Si on se rend ici, c'est que le "token" du cookie "Remember me" n'existe
       pas en BD pour l'utilisateur donné ou il a expiré. Ce faisant, on ne peut
       pas réactiver la session PHP. */
    return false;
}
function registerView(){
    if(isset($_SESSION['courriel'])){
    echo 'Vous etes deja connecter. Veuiller vous deconnecter avant de vous inscrire.';
    listProduits();
    }
    else{
       
        require('view/inscriptionView.php');
    }
}
function registerVerif($infoRegister){
    $utilisateurManager = new UtilisateurManager();
    if($utilisateurManager->alreadyRegistered($_REQUEST['courriel'])){
        echo 'Un utilisateur est deja inscrit avec ce courriel ';
        listProduits();
    }
    else{ 
        $utilisateurManager->registerUser($infoRegister);
        listProduits();
    }
}
function checkTokenInscription($id, $token){
    $utilisateurManager = new UtilisateurManager();
    if($utilisateurManager->getUserByIdAndToken($id, $token)){
        echo 'succes';
        $utilisateurManager->setActif($id);
        listProduits();
    }
    else{
        echo "bad verification. we'll get em next time buddy";
    }
}
function getUserIdByCourriel($courriel)
{
    $utilisateurManager = new UtilisateurManager();
    $utilisateur = $utilisateurManager->getUtilisateurParCourriel($courriel);
    $id = $utilisateur->get_id_utilisateur();
    return $id;
}

?>