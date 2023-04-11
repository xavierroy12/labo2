<?php $title = 'achat';
$titreH1 = 'Les achats'; 
?>
<button id="buttonGet">Tester AJAX</button>

<?php ob_start(); ?>

<h1><?=$titreH1?></h1>

<form method="post" action="checkout.php">
	<table>
		<tr>
			<th>Product</th>
			<th>Quantity</th>
			<th>Price/Unit</th>
			<th>Total</th>
		</tr>
		<?php
			// Assuming $produits is an array of produit objects
			$total = 0;
			$products = array();
			foreach ($produits as $produit) {
				$name = $produit->get_produit();
				$price = $produit->get_prix();
				$quantity = $_POST[$name] ?? 0;
				$subTotal = $price * $quantity;
				$total += $subTotal;
				$id = $produit->get_id_produit();

				echo "<tr>
						<td style='display:none;'>$id</td>
						<td>$name</td>
						<td><input type='number' name='$name' value='$quantity'></td>
						<td>$price</td>
						<td>$subTotal</td>
					</tr>";
			
			}
		?>
		<tr>
			<td colspan="3" >Total:</td>
			<td><?php echo $total; ?></td>
		</tr>
	</table>
	<script src="https://www.paypal.com/sdk/js?client-id=AUT_EDy7i7Y9hVx22JFnRWj2DMQ0vj95Tg6aUs9ddSrsb1jpdgIH7b6X0czwqnkI7D4gCatMxsxKgmSy&currency=CAD"></script>
	<div id="paypal-button-container"></div>
</form>

<script src="inc/script.js"></script>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>