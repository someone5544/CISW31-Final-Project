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
	  if(!edit_product($_POST['prod_id'], $_POST['prod_name'], $_POST['prod_price'], $_POST['prod_desc'], $_POST['prod_notes'], $_POST['prod_onhand'], $_POST['prod_image'])) {
		  // We couldn't edit the product.
		  $error = "Error while editing product, please try again.";
	  }
	  else {
		  $error = "Product ".htmlspecialchars($_POST['prod_name'])." was edited.";
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
$product = get_product_info(trim($_GET['id']));
if($product) {
?>
      <form action="admin_edit.php?id=<?=trim($_GET['id']);?>" method="post">
      <input type="hidden" name="prod_id" value="<?=htmlspecialchars($product['plu_id']); ?>">
      <tr><td colspan="3"><span style="font-size: large"><b>Edit Product</b></span></td></tr>
      <tr><td>Name:</td><td>&nbsp;</td><td><input type="text" name="prod_name" value="<?=htmlspecialchars($product['prod_name']); ?>" size="20" maxlength="25"></td></tr>
      <tr><td>Price:</td><td>&nbsp;</td><td><input type="text" name="prod_price" value="<?=number_format($product['prod_price'], 2); ?>" size="4" maxlength="5"></td></tr>
      <tr><td>Description:</td><td>&nbsp;</td><td><input type="text" name="prod_desc" value="<?=htmlspecialchars($product['prod_desc']); ?>" size="40" maxlength="100"></td></tr>
      <tr><td>Notes:</td><td>&nbsp;</td><td><input type="text" name="prod_notes" value="<?=htmlspecialchars($product['prod_notes']); ?>" size="40" maxlength="100"></td></tr>
      <tr><td>Stock:</td><td>&nbsp;</td><td><input type="text" name="prod_onhand" value="<?=htmlspecialchars($product['prod_onhand']); ?>" size="4" maxlength="4"></td></tr>
      <tr><td>Image Name:</td><td>&nbsp;</td><td><input type="text" name="prod_image" value="<?=htmlspecialchars($product['prod_image']); ?>" size="20" maxlength="30"></td></tr>
      <tr><td colspan="3" style="text-align: center"><input type="submit" value="Save"></td></tr>
      </form>
<?php
}
?>
    </table>
  </div>
<?php
  require('footer.php');
?>