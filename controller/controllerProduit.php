<?php

require('model/ProduitManager.php');
require('model/CategorieManager.php');

function listProduits()
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories(); 
    require('view/produitsView.php');
}

function produit($idProduit)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);    

    require('view/produitView.php');
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
    $produitManager->deleteProduit($id);
}
function insertProduit($produit, $categorie, $description)
{
    $produitManager = new ProduitManager();
    $idLastInsert = $produitManager->insertProduit($produit, $categorie, $description);
    return $idLastInsert;
  
}