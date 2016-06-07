<?php
include_once("inc/db.php");

function get_products() {
  // Query database for available products.
  $db = connect_db();
  $q = "SELECT * FROM Products";
  $res = @$db->query($q);

  if(!$res)
    return false;

  $res = res_to_array($res);
  $db->close();
  return $res;
}

function check_product($id) {
  // Check if product is valid.
  $id = addslashes($id);
  $db = connect_db();
  $q = "SELECT prod_name FROM Products WHERE plu_id='".$id."'";
  $res = @$db->query($q);
  $num_rows = @$res->num_rows;
  $db->close();

  if($num_rows > 0)
    return true;
  else
    return false;
}

function get_product_info($id) {
  // Return product information for given ID.
  if(!check_product($id))
    return false;
  $db = connect_db();
  $q = "SELECT * FROM Products WHERE plu_id='".$id."'";
  $res = @$db->query($q);

  if(!$res)
    return false;

  $res = @$res->fetch_assoc();
  $db->close();
  return $res;
}

function display_products($products) {
  // Output HTML to display products.
  $item = 0;
  foreach($products as $product) {
    if($item == 0) {
      echo "<div class=\"row\">\n";
    }
    echo "<div class=\"col-sm-4 text-center\">\n";
    echo "<img src=\"images/".$product['prod_image']."\" alt=\"Product\" width=\"250\" height=\"180\">\n";
    echo "<p><span style=\"font-weight: bold;\">".htmlspecialchars($product['prod_name'])."</span><br>\n";
    echo htmlspecialchars($product['prod_desc'])."<br>\n".htmlspecialchars($product['prod_notes'])."<br>\n";
    echo "<b>$".number_format($product['prod_price'], 2)."</b><br>\n";
    echo "<button type=\"button\" class=\"btn btn-primary btn-md\" onclick=\"addToCart('".$product['plu_id']."', 1);\"><span class=\"glyphicon glyphicon-shopping-cart\"></span> Add to Cart</button>\n";
    echo "</p>\n</div>\n";
    $item++;
    if($item == 3) {
      echo "</div>\n";
      $item = 0;
    }
  }
  if($item != 0) {
	echo "</div>\n";
  }
}
?>
