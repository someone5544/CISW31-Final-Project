<?php
include_once("inc/db.php");
include_once("inc/products.php");

function calculate_subtotal($cart) {
  // Calculate total price of items in cart.
  $subtotal = 0;
  foreach($cart as $itemid => $qty) {
	  $info = get_product_info($itemid);
	  $subtotal += $info['prod_price'] * $qty;
  }
  return $subtotal;
}

function calculate_qty($cart) {
  // Add total quantities in cart.
  $total = 0;
  foreach($cart as $items) {
    $total += $items;
  }
  return $total;
}

function display_cart($cart) {
  // Output HTML to display the cart.
  if(empty($cart)) {
    echo "<table align=\"center\"><tr><td style=\"text-align: center\">Your cart is empty.</td></tr></table>\n";
  }
  else {
	echo "<table align=\"center\" class=\"table\" style=\"max-width: 800px;\">\n";
	echo "<tr><th>Product</th><th style=\"text-align: right\">Qty.</th><th>&nbsp;</th><th style=\"text-align: right\">Sub-total</th></tr>\n";
    foreach($cart as $prod_id => $qty) {
	  $prod_info = get_product_info($prod_id);
	  $subtot = number_format($prod_info['prod_price'] * $qty, 2);
	  echo "<tr>";
	  echo "<td>".htmlspecialchars($prod_info['prod_name'])."</td>";
	  echo "<td style=\"text-align: right\"><input type=\"text\" id=\"".$prod_id."\" value=\"".$qty."\" size=\"2\" maxlength=\"2\"></td>";
	  echo "<td><button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"addToCart('".$prod_id."', document.getElementById('".$prod_id."').value);\"><span class=\"glyphicon glyphicon-refresh\"></span></button>&nbsp;";
	  echo "<button type=\"button\" class=\"btn btn-primary btn-sm\" onclick=\"addToCart('".$prod_id."', 0);\"><span class=\"glyphicon glyphicon-remove\"></span></button></td>";
	  echo "<td style=\"text-align: right\">$".$subtot."</td>";
	  echo "</tr>\n";
	}
	echo "<tr><td colspan=\"3\" style=\"text-align: right\"><b>Total:</b></td><td style=\"text-align: right\">$".number_format(calculate_subtotal($_SESSION['cart']), 2)."</td></tr>\n";
	echo "<tr><td colspan=\"4\" style=\"text-align: center\"><a href=\"checkout.php\" class=\"btn btn-primary btn-md\">Checkout</a></td></tr>\n";
	echo "</table>\n";
  }
}
?>
