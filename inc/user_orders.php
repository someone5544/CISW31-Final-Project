<?php
include_once("inc/db.php");
include_once("inc/session.php");
include_once("inc/products.php");

function get_user_orders() {
  // Get all orders for logged in user.
  if(!user_logged_in()) {
    return false;
  }

  $db = connect_db();
  $q = "SELECT order_num, order_date FROM Orders WHERE cust_id='".$_SESSION['user']."'";
  $res = @$db->query($q);

  if(!$res) {
    return false;
  }

  $res = res_to_array($res);
  return $res;
}

function get_user_order($orderid) {
  // Get info for a specific order.
  if($orderid == "") {
    return false;
  }

  $db = connect_db();
  $q = "SELECT * FROM Orders WHERE order_num='".$orderid."' AND cust_id='".$_SESSION['user']."'";
  $res = $db->query($q);

  if(@$res->num_rows < 1) {
    // Order does not exist for this user.
    return false;
  }

  $q = "SELECT * FROM OrderItems WHERE order_num='".$orderid."'";
  $res = $db->query($q);
  if(!$res) {
    return false;
  }

  $res = res_to_array($res);
  $db->close();
  return $res;
}

function calculate_order_total($order_products) {
  // Calculate total for given order.
  if(empty($order_products)) {
	  return 0;
  }
  $total = 0;
  foreach($order_products as $prod) {
    $total += $prod['quantity'] * $prod['prod_price'];
  }
  return $total;
}

function display_orders($orders) {
  // Output HTML to display user's orders.
  if(empty($orders)) {
    echo "<table align=\"center\"><tr><td style=\"text-align: center\">You have no orders.</td></tr></table>\n";
  }
  else {
	echo "<table align=\"center\" class=\"table\" style=\"max-width: 800px;\">\n";
	echo "<tr><th>Order Number</th><th>Order Date</th><th>Products Ordered</th><th style=\"text-align: right\">Total</th></tr>\n";
    foreach($orders as $order) {
	  $order_info = get_user_order($order['order_num']);
	  $subtot = number_format(calculate_order_total($order_info), 2);
	  echo "<tr>";
	  echo "<td><a href=\"order_view.php?o=".$order['order_num']."\"><b>".$order['order_num']."</b></a></td>";
	  echo "<td>".$order['order_date']."</td>";
	  echo "<td>".sizeof($order_info)."</td>";
	  echo "<td style=\"text-align: right\">$".$subtot."</td>";
	  echo "</tr>\n";
	}
	echo "</table>\n";
  }
}

function display_order($order) {
  // Output HTML to display a single order.
  if(empty($order)) {
    echo "<table align=\"center\"><tr><td style=\"text-align: center\">Invalid order.</td></tr></table>\n";
  }
  else {
	echo "<table align=\"center\" class=\"table\" style=\"max-width: 800px;\">\n";
	echo "<tr><td colspan=\"3\">Order #".$order[0]['order_num']."</td></tr>\n";
	echo "<tr><th>Product</th><th>Qty.</th>><th style=\"text-align: right\">Sub-total</th></tr>\n";
	$total = 0;
    foreach($order as $product) {
	  $product_info = get_product_info($product['plu_id']);
	  $subtot = number_format($product['prod_price'] * $product['quantity'], 2);
	  $total += $subtot;
	  echo "<tr>";
	  echo "<td>".htmlspecialchars($product_info['prod_name'])."</td>";
	  echo "<td>".$product['quantity']."</td>";
	  echo "<td style=\"text-align: right\">$".$subtot."</td>";
	  echo "</tr>\n";
	}
	echo "<tr><td colspan=\"2\" style=\"text-align: right\"><b>Total:</b></td><td style=\"text-align: right\">$".number_format($total, 2)."</td></tr>\n";
	echo "</table>\n";
  }
}
?>
