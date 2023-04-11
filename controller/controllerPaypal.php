<?php
// Ne modifiez pas cette fonction. Elle est complète et appelée par la fonction « registerOrder() ».
function createOrder(array &$paypalInfos) : object {
    require('./vendor/autoload.php');

    $request = new PayPalCheckoutSdk\Orders\OrdersCreateRequest();
    $request->prefer('return=representation');
    $request->body = buildRequestBody($paypalInfos);

    if (!empty($request->body)) {
        $client = Sample\PayPalClient::client();
        return $client->execute($request);
    }

    return null;
}

function buildRequestBody(array &$paypalInfos) : array {
    require_once('./model/ProduitManager.php');
    $produitManager = new ProduitManager();

    $items = array();
    foreach ($paypalInfos['orderItems'] as $index => $orderItem) {
        $product = $produitManager->getProduit($orderItem['id']);
        $quantity = $orderItem['quantity'];
        $item = array(
            'unit_amount' => array(
                'value' => $product->get_prix(),
                'currency_code' => 'CAD',
            ),
            'quantity' => $quantity,
        );
        array_push($items, $item);
    }

    $itemTotalValue = array_reduce($items, function($acc, $item) {
        return $acc + ($item['unit_amount']['value'] * $item['quantity']);
    }, 0);

    return array(
        'intent' => 'CAPTURE',
        'application_context' => array(
            // Ces URL n’ont pas à être modifiées, car elles ne serviront pas dans ce laboratoire
            'return_url' => 'http://localhost/paypal?return=ok',
            'cancel_url' => 'http://localhost/paypal?return=cancel'
        ),
        'purchase_units' => array(
            0 => array(
                'amount' => array(
                    'currency_code' => 'CAD',
                    'value' => strval($itemTotalValue),
                    'breakdown' => array(
                        'item_total' => array(
                            'value' => strval($itemTotalValue),
                            'currency_code' => 'CAD'
                        )
                    )
                ),
                'items' => $items
            )
        )
    );
}
    /*require_once('./model/ProduitManager.php');



        return array(
            'intent' => 'CAPTURE',
            'application_context' => array(
                // Ces URL n’ont pas à être modifiées, car elles ne serviront pas dans ce laboratoire
                'return_url' => 'http://localhost/paypal?return=ok',
                'cancel_url' => 'http://localhost/paypal?return=cancel'
                                          ),
            'purchase_units' => array(
                0 => array(
                    'amount' => array(
                        'currency_code' => 'CAD',
                        'value' => '13.93',         // Montant total de la commande (à calculer)
                        'breakdown' => array(
                            'item_total' => array(
                                'value' => '13.93', // Montant total de la commande (à calculer)
                                'currency_code' => 'CAD'
                                                 )
                                            )
                                     ),
                        'items' => array(
                            0 => array(
                                'name' => 'Produit 1', // Nom du produit 1 (à modifier)
                                'unit_amount' => array(
                                    'value' => '3.95', // Prix unitaire du produit 1 (à modifier)
                                    'currency_code' => "CAD"
                                                      ),
                                    'quantity' => $paypalInfos['quantite'][0]  // Quantité du produit 1 (à modifier)
                                      ),
                            1 => array(
                                'name' => 'Produit 2', // Nom du produit 2 (à modifier)
                                'unit_amount' => array(
                                    'value' => '4.99', // Prix unitaire du produit 2 (à modifier)
                                    'currency_code' => "CAD"
                                                      ),
                                    'quantity' => $paypalInfos['quantite'][0]  // Quantité du produit 2 (à modifier)
                                  )
                            )
                      )
                )
          );
    }
    */


function registerOrder(int $idUtilisateur, array $paypalInfos) : object {
    $paypalTransaction = createOrder($paypalInfos);
    
    if (!is_null($paypalTransaction)) {
        require('./model/CommandeManager.php');
        
        // Procédez à l’insertion de la commande et des informations de la transaction Paypal dans
        // les tables tbl_commande_produit et tbl_commande respectivement et ce, à l’aide du fichier
        // CommandeManager.php.
        
        return $paypalTransaction;
    }

    return null;
}

// Ajoutez ici la fonction qui permettra d’enregistrer dans la BD les informations de l’acheteur à partir
// de l’événement « checkout order approved ». Ajoutez aussi la fonction qui permettra de faire passer à
// 1 le statut de la commande sur réception de l’événement « payment capture completed ».

?>