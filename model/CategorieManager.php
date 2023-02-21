<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Categorie.php");

class CategorieManager extends Manager
{
    public function getCategories()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM tbl_categorie ORDER BY id_categorie');

        $categories = array();

        while($data = $req->fetch()){
            array_push($categories, new Categorie($data));
        }
       
        $req->closeCursor();
        return $categories;
    }
    public function getCategoriesName()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT categorie FROM tbl_categorie ORDER BY id_categorie');

     
        $categories = $req->fetchall();

        
       
        $req->closeCursor();
        return $categories;
    }
}