<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Produit.php");

class ProduitManager extends Manager
{
    public function getProduits()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM tbl_produit ORDER BY id_produit');

        $produits = array();

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }

        $req->closeCursor();
        return $produits;
    }

    public function getProduit($produitId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT p.*, categorie FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE id_produit = ?');
        $req->execute(array($produitId));
        $produit = new Produit($req->fetch());
        $req->closeCursor();
        return $produit;
        
    }
    public function getProduitCategories($id_categorie){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT p.*, c.categorie FROM tbl_produit as p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE p.id_categorie = :idCategorie');
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
        $req->execute(array(":categorie" => $categorie, ":descr" => $description, ":produit" => $produit));
        return $idProduit =  $db->lastInsertId();
    }
    public function deleteProduit($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare("DELETE FROM tbl_produit WHERE id_produit = :id");
        $req->execute(array(":id" => $id));
    }
    

}
?>