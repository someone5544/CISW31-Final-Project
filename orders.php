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
  	<h2>My Orders</h2><br>
    <?php
	$orders = get_user_orders();
    display_orders($orders);
	?>
    <br><br>
    <p style="text-align: center"><a href="user.php" class="btn btn-primary btn-md">My Account</a></p>
  </div>
<?php
  require('footer.php');
?>