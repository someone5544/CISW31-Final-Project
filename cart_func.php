<?php
header('Content-type: application/json');
require("inc/session.php");
require("inc/products.php");

$prod_id = trim($_POST['id']);
$qty = trim($_POST['q']);

function output_json($status, $message) {
	$output = array('status' => $status, 'msg' => $message);
	return json_encode($output);
}

// Check for empty product ID.
if(empty($prod_id)) {
	die(output_json(0, "Invalid product ID."));
}

// Check for empty or non-numeric quantity.
if(!is_numeric($qty) || $qty == "") {
	die(output_json(0, "Invalid quantity."));
}

// Check if product ID is valid.
if(!check_product($prod_id)) {
	die(output_json(0, "Invalid product ID."));
}

// If quantity is 0 and product is in cart, remove it.
if($qty == 0) {
	unset($_SESSION['cart'][$prod_id]);
	die(output_json(1, "Removed product from cart."));
}

// If product is in cart, update quantity, otherwise add product to cart with quantity.
if(isset($_SESSION['cart'][$prod_id])) {
	$_SESSION['cart'][$prod_id] = $qty;
	die(output_json(1, "Updated quantity."));
}
else {
	$_SESSION['cart'][$prod_id] = $qty;
	die(output_json(1, "Added product to cart."));
}

?>