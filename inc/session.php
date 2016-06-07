<?php
session_start();
include_once("inc/db.php");
include_once("inc/validation.php");

if(!isset($_SESSION['cart'])) {
  // Set cart session data if it is not set.
  
  $_SESSION['cart'] = array();
  $_SESSION['cart_items'] = 0;
  $_SESSION['cart_subtotal'] = 0;
}

if(!isset($_SESSION['user'])) {
  // Set user ID session data if it is not set.
  
  $_SESSION['user'] = NULL;
  $_SESSION['user_admin'] = false;
}

function user_logged_in() {
  // Check if user is logged in.
  
  if(!isset($_SESSION['user']) || is_null($_SESSION['user']))
    return false;
  else
    return true;
}

function log_in_user($email, $pass) {
  // Attempt to log in user.
  
  if(!valid_email($email) || $pass == "") {
    return false;
  }
  $pass = hash("sha256", $pass);
  $email = addslashes($email);
  $db = connect_db();
  $q = "SELECT * FROM Customers WHERE cust_email='".$email."' AND cust_password='".$pass."'";
  $res = @$db->query($q);
  if(!$res) {
	$db->close();
    return false;
  }
  $res = @$res->fetch_assoc();
  $db->close();
  if(empty($res)) {
    return false;
  }
  else {
    // Able to retrieve user info.
    $_SESSION['user'] = $res['cust_id'];
    if($res['administrator'] > 0) {
      $_SESSION['user_admin'] = true;
	}
	else {
		$_SESSION['user_admin'] = false;
	}
  }
}

function load_user_info() {
	// Load logged in user's information.
	
	if(!user_logged_in()) {
		return false;
	}
	$db = connect_db();
	$q = "SELECT cust_email, cust_name, cust_address, cust_city, cust_state, cust_zip FROM Customers WHERE cust_id='".$_SESSION['user']."'";
	$res = @$db->query($q);
	if(!$res) {
		$db->close();
		return false;
	}
	$res = @$res->fetch_assoc();
	$db->close();
	return $res;
}

function user_admin_level() {
  // Check if user is an administrator.
  
  if(!isset($_SESSION['user_admin']) || is_null($_SESSION['user_admin']) || !$_SESSION['user_admin'])
    return false;
  else
    return true;
}

function reset_session() {
  // Reset the cart.
  
  unset($_SESSION['cart'], $_SESSION['cart_items'], $_SESSION['cart_subtotal']);
  $_SESSION['cart'] = array();
  $_SESSION['cart_items'] = 0;
  $_SESSION['cart_subtotal'] = 0;
}

function end_session() {
  // Destroy the current session.
  
  unset($_SESSION);
  session_destroy();
}
?>
