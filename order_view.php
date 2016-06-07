<?php
  
  require('inc/session.php');
  if(!user_logged_in()) {
	  // Check if user is logged in.
	  header('Location: login.php');
	  exit;
  }
  require('header.php');
  require('inc/user_orders.php');
  
?>
  <!-- page content -->
  <div class="content">
  	<h2>Order Information</h2><br>
<?php
$order_products = get_user_order($_GET['o']);
display_order($order_products);
?>
    <br><br>
    <p style="text-align: center"><a href="orders.php" class="btn btn-primary btn-md">My Orders</a></p>
  </div>
<?php
  require('footer.php');
?>