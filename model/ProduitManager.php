<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Produit.php");

class ProduitManager extends Manager
{
    const SELECT_ALL_PRODUITS = "SELECT id_produit, id_categorie, produit_:lang AS produit, description_:lang AS description FROM tbl_produit";
    public function getProduits()
    {
        $db = $this->dbConnect();

        $req = $db->query(str_replace(':lang', $_SESSION['language'], self::SELECT_ALL_PRODUITS));

        $produits = array();

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }

        $req->closeCursor();
        return $produits;
    }
    const SELECT_PRODUIT_ID = "SELECT id_produit, p.id_categorie, produit_:lang AS produit, p.description_:lang AS description, c.categorie_:lang FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE id_produit = ?";
    public function getProduit($produitId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare(str_replace(':lang', $_SESSION['language'], self::SELECT_PRODUIT_ID));
       // $result = $req->execute(array($produitId));
       $result = $req->execute(array($produitId));

        if($req->rowCount() == 0) {
            $req->closeCursor();
            return NULL;
            
        }

        else{
        $produit = new Produit($req->fetch());
        $req->closeCursor();
        return $produit;
            }
        
    }
    const SELECT_PRODUIT_CAT = "SELECT id_produit, p.id_categorie, produit_:lang AS produit, p.description_:lang AS description, c.categorie_:lang FROM tbl_produit as p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE p.id_categorie = :idCategorie";
    public function getProduitCategories($id_categorie){
        $db = $this->dbConnect();
        $req = $db->prepare(str_replace(':lang', $_SESSION['language'], self::SELECT_PRODUIT_CAT));
        $req->execute(array(":idCategorie" => $id_categorie));
        $produits = array();
        $tableDonnees = $req->fetchAll();

        foreach ($tableDonnees as $data) {
            array_push($produits, new Produit($data));
        }
        $req->closeCursor();
        return $produits;

    }
    public function insertProduit($produit, $categorie, $description){
        $db = $this->dbConnect();

        $req = $db->prepare("INSERT INTO tbl_produit (tbl_produit.id_categorie, produit, tbl_produit.description) VALUES((SELECT tbl_categorie.id_categorie FROM tbl_categorie WHERE categorie = :categorie), :produit, :descr)");
        try {
            $req->execute(array(":categorie" => $categorie, ":descr" => $description, ":produit" => $produit));
            return $idProduit =  $db->lastInsertId();
        } catch (PDOException $erreur) {
            return -1;
        }

        
    }
    public function deleteProduit($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("DELETE FROM tbl_produit WHERE id_produit = :id");
        $req->execute(array(":id" => $id));
        if($req->rowCount() == 0) {
            return NULL;
            }
        else
        return 1;
    }
    

}
