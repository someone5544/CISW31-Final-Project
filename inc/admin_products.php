<?php
include_once("inc/db.php");
include_once("inc/products.php");

function edit_product($id, $name, $price, $desc, $notes, $stock, $image) {
  // Update information for a product.
  
  // Check that we have valid input.
  if($id == "" || $name == "" || $price == "" || $desc == "" || $notes == "" || $stock == "" || $image == "" || !is_numeric($stock)) {
    return false;
  }
  if(!check_product($id)) {
    return false;
  }

  // Update product information.
  $db = connect_db();
  $q = "UPDATE Products SET prod_name=?, prod_price=?, prod_desc=?, prod_notes=?, prod_onhand=?, prod_image=? WHERE plu_id=?";
  $update = $db->prepare($q);
  $update->bind_param("sdssiss", $name, $price, $desc, $notes, $stock, $image, $id);
  if($update->execute()) {
    $db->close();
    return true;
  }
  else {
    $db->close();
    return false;
  }
}

function add_product($id, $name, $price, $desc, $notes, $stock, $image) {
  // Insert new product to the database.
  
  // Check that we have valid input.
  if($id == "" || $name == "" || $price == "" || $desc == "" || $notes == "" || $stock == "" || $image == "" || !is_numeric($stock)) {
    return false;
  }
  
  $db = connect_db();
  $id = addslashes($id);
  // Check if product ID exists.
  $q = "SELECT prod_name FROM Products WHERE plu_id='".$id."'";
  $res = @$db->query($q);
  $num_rows = @$res->num_rows;
  if($num_rows > 0) {
	  // Product exists, don't add product.
	  $db->close();
	  return false;
  }
  // Insert new product.
  $q = "INSERT INTO Products VALUES(?, ?, ?, ?, ?, ?, ?)";
  $update = $db->prepare($q);
  $update->bind_param("ssdssis", $id, $name, $price, $desc, $notes, $stock, $image);
  if($update->execute()) {
    $db->close();
    return true;
  }
  else {
    $db->close();
    return false;
  }
}
?>
