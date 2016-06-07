<?php
  
  require('header.php');
  require('inc/session.php');
  require('inc/cart.php');
  
?>
  <!-- page content -->
  <div class="content">
  	<h2>Shopping Cart</h2><br>
    <?php display_cart($_SESSION['cart']); ?>
    <br><br>
    <p style="text-align: center"><a href="user.php" class="btn btn-primary btn-md">My Account</a></p>
  </div>
<?php
  require('footer.php');
?>