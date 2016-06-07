<?php
  
  require('inc/session.php');
  if(!user_logged_in()) {
	  // Check if user is logged in.
	  header('Location: login.php');
	  exit;
  }
  // Reset the cart.
  reset_session();
  require('header.php');
  
?>
  <!-- page content -->
  <div class="content">
  	<h2>Order Confirmed</h2><br>
    <p style="text-align: center">Your order was submitted and will be processed shortly, thank you.</p>
  </div>
<?php
  require('footer.php');
?>