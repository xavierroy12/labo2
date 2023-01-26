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

        return $produit;
    }
    public function getProduitCategories($id_categorie){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT p.*, c.categorie FROM tbl_produit as p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE p.id_categorie = :idCategorie');
        //$req = $db->prepare('SELECT produit FROM tbl_produit WHERE id_categorie =' echo $id_categoire  );
        $req->execute(array(":idCategorie" => $id_categorie));
        //$produit = new Categorie($req->fetch());
        $produits = array();
        $tableDonnees = $req->fetchAll();

        foreach ($tableDonnees as $data) {
            array_push($produits, new Produit($data));
        }
        return $produits;

    }

}
?>