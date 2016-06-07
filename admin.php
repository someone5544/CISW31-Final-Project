<?php
  
  require('inc/session.php');
  if(!user_logged_in() || !user_admin_level()) {
	  // Check if user is logged in and is an administrator.
	  header('Location: index.php');
	  exit;
  }
  require('header.php');
  require('inc/products.php');
  require('inc/admin_products.php');
  
  if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
	  // Posting to page, store all information.
	  if(!add_product($_POST['prod_id'], $_POST['prod_name'], $_POST['prod_price'], $_POST['prod_desc'], $_POST['prod_notes'], $_POST['prod_onhand'], $_POST['prod_image'])) {
		  // We couldn't add the product.
		  $error = "Error while adding new product, please try again.";
	  }
	  else {
		  $error = "Product ".htmlspecialchars($_POST['prod_name'])." was added.";
	  }
  }
  
?>
  <!-- page content -->
  <div class="content">
  	<h2>Administration</h2><br>
    <table align="center">
<?php
if(isset($error)) {
	echo "<tr><td colspan=\"3\" style=\"text-align: center\"><b>".$error."</b></td></tr>\n";
}
?>
      <form action="admin.php" method="post">
      <tr><td colspan="3"><span style="font-size: large"><b>Add Product</b></span></td></tr>
      <tr><td>ID:</td><td>&nbsp;</td><td><input type="text" name="prod_id" size="4" maxlength="4"></td></tr>
      <tr><td>Name:</td><td>&nbsp;</td><td><input type="text" name="prod_name" size="20" maxlength="25"></td></tr>
      <tr><td>Price:</td><td>&nbsp;</td><td><input type="text" name="prod_price" size="4" maxlength="5"></td></tr>
      <tr><td>Description:</td><td>&nbsp;</td><td><input type="text" name="prod_desc" size="40" maxlength="100"></td></tr>
      <tr><td>Notes:</td><td>&nbsp;</td><td><input type="text" name="prod_notes" size="40" maxlength="100"></td></tr>
      <tr><td>Initial Stock:</td><td>&nbsp;</td><td><input type="text" name="prod_onhand" size="4" maxlength="4"></td></tr>
      <tr><td>Image Name:</td><td>&nbsp;</td><td><input type="text" name="prod_image" size="20" maxlength="30"></td></tr>
      <tr><td colspan="3" style="text-align: center"><input type="submit" value="Insert Product"></td></tr>
      </form>
      <tr><td colspan="3">&nbsp;</td></tr>
      <form action="admin_edit.php" method="get">
      <tr><td colspan="3"><span style="font-size: large"><b>Edit Product</b></span></td></tr>
      <tr><td>Product:</td><td>&nbsp;</td><td><select name="id">
<?php
$products = get_products();
foreach($products as $product) {
	echo "<option value=\"".$product['plu_id']."\">".htmlspecialchars($product['prod_name'])."</option>\n";
}
?>
</select></td></tr>
      <tr><td colspan="3" style="text-align: center"><input type="submit" value="Edit Product"></td></tr>
      </form>
    </table>
  </div>
<?php
  require('footer.php');
?>