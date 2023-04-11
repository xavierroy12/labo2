<?php
require('model/ProduitManager.php');
require('model/CategorieManager.php');

function listProduits($estApi)
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories(); 
    if($estApi === FALSE)
    require('view/produitsView.php');
    else{
        return $produits;
    }
}
function listProduitsAchat()
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories(); 
    require('view/achatView.php');
}
function listProduitAchatNoView(){
    
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories(); 
    require('inc/achatJSON.php');
}

function produit($idProduit,$estApi)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);    
    if($estApi === FALSE)
    require('view/produitView.php');
    else{
        return $produit;
    }
  
}

function listProduitsCategorie($idCategorie)
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduitCategories($idCategorie);
    $categorie = $produits[1]->get_categorie();
    require('view/produitsView.php');
}
function deleteProduit($id)
{
    $produitManager = new ProduitManager();
    $result = $produitManager->deleteProduit($id);
    return $result;
}
function insertProduit($produit, $categorie, $description)
{
    $produitManager = new ProduitManager();
    $idLastInsert = $produitManager->insertProduit($produit, $categorie, $description);
    return $idLastInsert;
  
}
?>