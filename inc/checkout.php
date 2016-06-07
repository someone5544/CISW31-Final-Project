<?php
include_once("inc/db.php");
include_once("inc/session.php");
include_once("inc/products.php");

function process_card($card_num, $card_mo, $card_yr, $card_verify) {
	// Process the credit card.
	if($card_num == "" || $card_mo == "" || $card_yr == "" || $card_verify == "") {
		// Check that values were provided.
		return false;
	}
	if(!is_numeric($card_num) || !is_numeric($card_mo) || !is_numeric($card_yr) || !is_numeric($card_verify)) {
		// Check that all values are numbers.
		return false;
	}
	if(strlen($card_num) > 16 || strlen($card_num) < 15 || strlen($card_mo) > 2 || strlen($card_yr) != 2 || strlen($card_verify) > 4) {
		// Check that values are within valid ranges.
		return false;
	}
	if($card_mo < 1 || $card_mo > 12) {
		// Check that valid month is given.
		return false;
	}
	$cur_year = date("Y");
	$cur_mo = date("m");
	$card_yr = "20".$card_yr;
	if($card_yr < $cur_year) {
		// Check card is not expired.
		return false;
	}
	if($card_yr == $cur_year && $card_mo < $cur_mo) {
		// Check month expiration if card expires this year.
		return false;
	}
	
	return true;
}

function store_order($cart) {
	// Store cart to database.
	if(!user_logged_in()) {
		return false;
	}
	$db = connect_db();
	$q = "SELECT MAX(order_num) AS max_order FROM Orders";
	$res = @$db->query($q);
	if(!$res) {
		$db->close();
		return false;
	}
	$next_order = @$res->fetch_assoc();
	$next_order = $next_order['max_order']+1;
	$q = "INSERT INTO Orders VALUES ('".$next_order."', NOW(), '".$_SESSION['user']."')";
	@$db->query($q);
	// Go through items in cart.
	$i = 1;
	foreach($cart as $item_id => $qty) {
		$item_info = get_product_info($item_id);
		$q = "INSERT INTO OrderItems VALUES ('".$next_order."', '".$i."', '".$item_id."', '".$qty."', '".$item_info['prod_price']."')";
		@$db->query($q);
		$q = "UPDATE Products SET prod_onhand=prod_onhand-".$qty." WHERE plu_id='".$item_id."'";
		@$db->query($q);
		$i++;
	}
	$db->close();
	return true;
}
?>
