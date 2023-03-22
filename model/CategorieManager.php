<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Categorie.php");

class CategorieManager extends Manager
{
    const SELECT_CATEGORIES = "SELECT id_categorie, categorie_:lang AS categorie, description_:lang AS description FROM tbl_categorie ORDER BY id_categorie";
    public function getCategories()
    {

        $db = $this->dbConnect();

        $req = $db->query(str_replace(':lang', $_SESSION['language'], self::SELECT_CATEGORIES));


        $categories = array();

        while($data = $req->fetch()){
            
            array_push($categories, new Categorie($data));
        }

        $req->closeCursor();
        return $categories;
    }
    const SELECT_CAT_NAME = 'SELECT categorie_:lang FROM tbl_categorie ORDER BY id_categorie';
    public function getCategoriesName()
    {
        $db = $this->dbConnect();
        $req = $db->query(str_replace(':lang', $_SESSION['language'], self::SELECT_CAT_NAME));

     
        $categories = $req->fetchall();

        
       
        $req->closeCursor();
        return $categories;
    }
}