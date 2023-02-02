<?php

require_once("model/Manager.php");
require_once("model/Utilisateur.php");


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


}