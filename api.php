<?php
header('Content-Type: application/json');
require("controller/controllerProduit.php");
if (isset($_REQUEST['objet'])) {
    switch ($_REQUEST['objet']) {
        case 'produit':
            switch ($_SERVER["REQUEST_METHOD"]) {
                case 'GET':
                    if (isset($_REQUEST['id'])) {
                        $produit = produit($_REQUEST['id'],TRUE);
                        if(is_null($produit)){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "Aucun produit ne correspond à votre requête."}'   ;
                        }
                        else{
                        http_response_code(200);
                        $produitJson = json_encode($produit, JSON_PRETTY_PRINT);
                        echo $produitJson;
                        }
                    }
                    else{
                        $produits = listProduits(TRUE);
                       
                        http_response_code(200);
                        $produitJson = json_encode($produits, JSON_PRETTY_PRINT);
                        echo $produitJson;
                        
                    }

                    break;
                case 'POST':
                    $infosNouveauProduit = json_decode(file_get_contents('php://input'), true);
                    if(isset($infosNouveauProduit["produit"]) && isset($infosNouveauProduit["id_categorie"]) && isset($infosNouveauProduit["description"])){
                        $lastId = insertProduit($infosNouveauProduit["produit"],$infosNouveauProduit["id_categorie"],$infosNouveauProduit["description"]);
                        if(is_null($lastId)){
                            http_response_code(400);
                            echo '{"ÉCHEC" : "L\'ajout du produit a échoué. L\'ID de la catégorie n’existe pas en BD."}';
                        }
                        else{
                        http_response_code(200);
                        echo '{"SUCCÈS" : "L\'ajout du produit a fonctionné."}';
                        }

                    }
                    else{
                        http_response_code(400);
                        echo '{"ÉCHEC" : "You are missing one or more values to be able to insert in the bd."}';
                    }

                    break;
                case 'PUT':
                    echo 'ceci est put';
                    break;
                case 'DELETE':
                    if (isset($_REQUEST['id'])) {
                        $id =  $_REQUEST['id'];
                        if(is_numeric($id)){
                            $result = deleteProduit($_REQUEST['id']);
                            echo $result;
                            if(is_null($result)){
                                http_response_code(400);
                                echo '{"ÉCHEC" : "Deletion failed."}';
                            }
                            else{
                                http_response_code(200);
                                echo '{"KING" : "succesfully deleted"}';
                            }

                        }
                        else{
                            http_response_code(400);
                            echo '{"ÉCHEC" : "Entered id is not a numerical value"}';
                        }
                        
                    }
                    break;
                default:
                    http_response_code(400);
                    echo '{"ÉCHEC" : "Seuls GET, POST, PUT ou DELETE sont permis."}';
            }
            break;
        default:
            http_response_code(400);
            echo '{"ÉCHEC" : "Seuls les produits peuvent être traités."}';
    }
}
?>
