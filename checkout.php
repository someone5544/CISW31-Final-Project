<?php

  require('inc/session.php');
  require('inc/cart.php');
  require('inc/checkout.php');
  require('inc/account.php');
  
  if(!user_logged_in()) {
	  // Check if user is logged in.
	  header('Location: login.php');
	  exit;
  }
  if(calculate_qty($_SESSION['cart']) < 1) {
	  // No items in cart, redirect to cart page.
	  header('Location: cart.php');
	  exit;
  }
  
  $cust_info = load_user_info();
  
  if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
	  // Posting to page, store all information.
	  if(!update_shipping($_POST['cust_name'], $_POST['cust_address'], $_POST['cust_city'], $_POST['cust_state'], $_POST['cust_zip'])) {
		  // Couldn't update address.
		  $error = "Error with shipping information, please try again.";
	  }
	  elseif(!process_card($_POST['cust_card'], $_POST['cust_exp_mo'], $_POST['cust_exp_yr'], $_POST['cust_verification'])) {
		  // Couldn't process card.
		  $error = "Error with payment information, please try again.";
	  }
	  elseif(!store_order($_SESSION['cart'])) {
		  // Couldn't store order.
		  $error = "Error submitting the order, please try again.";
	  }
	  else {
		  // Everything went fine, send user to thanks page.
		  header('Location: order_complete.php');
		  exit;
	  }
  }
  
  require('header.php');
  
?>
  <!-- page content -->
  <div class="content">
  	<h2>Checkout</h2><br>
    <form action="checkout.php" method="post">
    <table align="center">
<?php
if(isset($error)) {
	echo "<tr><td colspan=\"3\" style=\"text-align: center\"><b>".$error."</b></td></tr>\n";
}
?>
      <tr><td colspan="3"><span style="font-size: large"><b>Shipping Information</b></span></td></tr>
      <tr><td>Name:</td><td>&nbsp;</td><td><input type="text" name="cust_name" value="<?=htmlspecialchars($cust_info['cust_name']); ?>" size="20" maxlength="50"></td></tr>
      <tr><td>Address:</td><td>&nbsp;</td><td><input type="text" name="cust_address" value="<?=htmlspecialchars($cust_info['cust_address']); ?>" size="40" maxlength="50"></td></tr>
      <tr><td>City:</td><td>&nbsp;</td><td><input type="text" name="cust_city" value="<?=htmlspecialchars($cust_info['cust_city']); ?>" size="40" maxlength="50"></td></tr>
      <tr><td>State:</td><td>&nbsp;</td><td><input type="text" name="cust_state"  value="<?=htmlspecialchars($cust_info['cust_state']); ?>" size="2" maxlength="2"></td></tr>
      <tr><td>ZIP:</td><td>&nbsp;</td><td><input type="text" name="cust_zip" value="<?=htmlspecialchars($cust_info['cust_zip']); ?>" maxlength="5" size="5"></td></tr>
      <tr><td colspan="3"><span style="font-size: large"><b>Payment Information</b></span></td></tr>
      <tr><td>Card Number:</td><td>&nbsp;</td><td><input type="text" name="cust_card" size="16" maxlength="16"></td></tr>
      <tr><td>Expiration Month:</td><td>&nbsp;</td><td><input type="text" name="cust_exp_mo" size="2" maxlength="2"></td></tr>
      <tr><td>Expiration Year:</td><td>&nbsp;</td><td><input type="text" name="cust_exp_yr" size="2" maxlength="2"></td></tr>
      <tr><td>CVC:</td><td>&nbsp;</td><td><input type="text" name="cust_verification" size="4" maxlength="4"></td></tr>
      <tr><td colspan="3" style="text-align: center"><input type="submit" value="Submit Order"></td></tr>
    </table>
    </form>
  </div>
<?php
  require('footer.php');
?>