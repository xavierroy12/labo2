<?php

require_once("model/Manager.php");
require_once("model/Utilisateur.php");
require_once("Util.php");


class UtilisateurManager extends Manager
{

    public function getUtilisateurParCourriel($courriel)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT *  FROM tbl_utilisateur WHERE courriel = ?');
        $req->execute(array($courriel));
        $data = $req->fetch();
        if($data){
        $user = new Utilisateur($data);
        return $user;
        }
        else{
        return null;
        }
    } 

    public function verifAuthentification($courriel, $motPasse)
    {
        $manager = new UtilisateurManager;
        $utilisateur = $manager->getUtilisateurParCourriel($courriel);
        if(($utilisateur != null)){
            $mdpHashed = $utilisateur->get_Mdp();
            $correctmdp = password_verify($motPasse, $mdpHashed);
            if($correctmdp)
            return $utilisateur;
            else
            return null;
        }
    }
    public function addUtilisateur($infoUtilisateur){
        $db = $this->dbConnect();
        $req = $db->prepare("INSERT INTO tbl_utilisateur ( nom, prenom, courriel,  est_actif, role_utilisateur, type_utilisateur) VALUES (:nom, :prenom, :courriel,1,0,1)");
        $req->execute(array(":courriel" => $infoUtilisateur['courriel'], ":nom" => $infoUtilisateur['nom'], ":prenom" => $infoUtilisateur['prenom']));
    }
    public function addAutoLogin($id_utilisateur,$courriel){
        $date = date_create('now'); //Create date right now
        date_add($date, date_interval_create_from_date_string("30 days")); // add 30 days to our date
        $date = date_format($date,"Y-m-d");

        $utilitaire = new Util(); //create Util to access get token
        $token = $utilitaire->getToken(16); // get a non hashed token with a lenght of 16
        $tokenHash = password_hash($token, PASSWORD_DEFAULT); // Get a hashed version of the token for the BD
        $timeBeforeExpire = REMEMBER_ME_COOKIE_DURATION;
       

        
        $db = $this->dbConnect();
        $req = $db->prepare("INSERT INTO tbl_autologin (id_utilisateur,token_hash,est_valide,date_expiration) VALUES (:idUser, :tokenHash, 1, :dateExpiration)");
        $req->execute(array(":idUser" => $id_utilisateur, ":tokenHash" => $tokenHash, ":dateExpiration" => $date));
       
        $utilitaire->setAuthCookie($id_utilisateur, $courriel, $token, $timeBeforeExpire); //calls a functino to set cookie
    }

    public function verifier_autologin($idUser, $randomToken){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT *  FROM tbl_autologin WHERE id_utilisateur = :idUser AND est_valide = 1');
        $req->execute(array(":idUser" => $idUser));
        $data = $req->fetch();

      
        $cookieData = json_decode($_COOKIE['remember_me'], true);

  
        if(password_verify($cookieData['token'] ,$data['token_hash'])){
            return true;
        }
        else{
           echo  'tryed to password verify, failed';
           return false;
        }
    }
    public function autoLoginSetInactif(){
        if(isset($_COOKIE['remember_me'])){
        $cookieValuesArray = json_decode($_COOKIE['remember_me'], true);
        $idUser = $cookieValuesArray['user_id'];
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE tbl_autologin SET est_valide = 0 WHERE id_utilisateur = :idUser');
        $req->execute(array(":idUser" => $idUser));
        }
    }
    public function alreadyRegistered($courrielRegister){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT *  FROM tbl_utilisateur WHERE courriel = :courriel');
        $req->execute(array(":courriel" => $courrielRegister));
        $data = $req->fetch();
        if($data){
            return true;
        }
        else{
            return false;
        }
    }
    public function registerUser($infoRegister){
        $utilitaire = new Util(); //create Util to access get token
        $token = $utilitaire->getToken(16); // get a non hashed token with a lenght of 16
        $tokenHash = password_hash($token, PASSWORD_DEFAULT); // Get a hashed version of the token for the BD
        $mdpHashed = password_hash($infoRegister['mdp'], PASSWORD_DEFAULT); // Get a hashed version of pwd for BD
        $db = $this->dbConnect();
        $req = $db->prepare("INSERT INTO tbl_utilisateur ( nom, prenom, courriel,mdp,  est_actif, role_utilisateur, type_utilisateur,token) VALUES (:nom, :prenom,:courriel, :mdp ,0,0,0,:token)");
        $req->execute(array(":courriel" => $infoRegister['courriel'], ":nom" => $infoRegister['nom'], ":prenom" => $infoRegister['prenom'], ':mdp' => $mdpHashed, ':token' => $tokenHash));
        $idUser =  $db->lastInsertId();

       

            $to = $infoRegister['courriel'];
            $subject = 'Hello from XAMPP!';
            $message = 'http://localhost/mvc/index.php?action=validation&id=' .  $idUser . '&token=' . $token;
            $headers = "From: your@email-address.com\r\n";
         
            if (mail($to, $subject, $message, $headers)) {
               echo "A verification email has been sent. Please confirm your email adress before connecting";
            } 
            else {
               echo "ERROR, failed to send the mail";
                 }
       
           
        

    }

    public function getUserByIdAndToken($id, $token){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT token  FROM tbl_utilisateur WHERE id_utilisateur = :id');
        $req->execute(array(":id" => $id, ));
        $data = $req->fetch();
      
   
        if($data){
            $verified = password_verify($token,$data['token']);//token isnt hashed, data token from databased is hashed
            if($verified){
                return true;
            }
        }
        else{
            echo 'mission failed';
            echo $data;
            return false;
        }
    }
    public function setActif($id){
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE tbl_utilisateur SET est_actif = 1 WHERE id_utilisateur = :id');
        $req->execute(array(":id" => $id));
    }


}