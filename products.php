<?php


	require('header.php');
	require('inc/products.php');

?>




	<!-- page content -->
<div class="container">
  <h2>Products</h2><br />
<?php
  $products = get_products();
  display_products($products);
?>
</div>



<?php


	require('footer.php');


?>
