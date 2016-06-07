<?php
include_once("inc/db.php");
include_once("inc/session.php");
include_once("inc/validation.php");

function update_password($oldpass, $newpass) {
  // Update user's password.
  
  if(user_logged_in()) {
	if(strlen($newpass) < 8) {
		// Password is too short.
		return false;
	}
    $db = connect_db();
    $q = "SELECT cust_password FROM Customers WHERE cust_id='".$_SESSION['user']."'";
    $res = @$db->query($q);
    $res = @$res->fetch_assoc();

    if($res['cust_password'] == hash("sha256", $oldpass)) {
      // Passwords match, store the new password.
      $q = "UPDATE Customers SET cust_password='".hash("sha256", $newpass)."' WHERE cust_id='".$_SESSION['user']."'";
      $res = @$db->query($q);
      $db->close();
      if($res)
        return true;
      else
        return false;
    }
    else {
      $db->close();
      return false;
    }
  }
  else {
    return false;
  }
}

function create_user($email, $password) {
  // Create user account.
  
  // Check that we have valid input.
  if(!valid_email($email) || $password == "" || strlen($password) < 8) {
	  return false;
  }
  if(user_logged_in()) {
	  // Check if user is logged in.
	  return false;
  }
  
  // Check email is unique.
  $db = connect_db();
  $email = addslashes($email);
  $q = "SELECT cust_id FROM Customers WHERE cust_email='".$email."'";
  $res = @$db->query($q);
  $num_rows = @$res->num_rows;
  if($num_rows > 0) {
	  $db->close();
	  return false;
  }
  
  // Get next ID.
  $q = "SELECT MAX(cust_id) AS next_id FROM Customers";
  $res = @$db->query($q);
  if(!$res) {
	  $db->close();
	  return false;
  }
  $next_id = @$res->fetch_assoc();
  $next_id = $next_id['next_id']+1;
  
  // Insert new customer.
  $password = hash("sha256", $password);
  $q = "INSERT INTO Customers VALUES (?, '', '', '', '', '', ?, ?, 0)";
  $update = $db->prepare($q);
  $update->bind_param("sss", $next_id, $email, $password);
  if($update->execute()) {
	  $db->close();
	  return true;
  }
  else {
	  $db->close();
	  return false;
  }
}
  

function update_information($name, $addr, $city, $state, $zip, $email) {
  // Update user's account information.
  
  if(!user_logged_in()) {
	  // Check if user is logged in.
	  return false;
  }
  // Check that we have valid input.
  if($name == "" || $addr == "" || $city == "" || $state == "" || $zip == "" || $email == "") {
    return false;
  }
  if(!valid_state($state) || !valid_zip($zip) || !valid_email($email)) {
    return false;
  }

  // Update user's information.
  $db = connect_db();
  $q = "UPDATE Customers SET cust_name=?, cust_address=?, cust_city=?, cust_state=?, cust_zip=?, cust_email=? WHERE cust_id=?";
  $update = $db->prepare($q);
  $state = strtoupper($state);
  $update->bind_param("sssssss", $name, $addr, $city, $state, $zip, $email, $_SESSION['user']);
  if($update->execute()) {
    $db->close();
    return true;
  }
  else {
    $db->close();
    return false;
  }
}

function update_shipping($name, $addr, $city, $state, $zip) {
  // Update user's shipping information.
  
  if(!user_logged_in()) {
	  // Check if user is logged in.
	  return false;
  }
  // Check that we have valid input.
  if($name == "" || $addr == "" || $city == "" || $state == "" || $zip == "") {
    return false;
  }
  if(!valid_state($state) || !valid_zip($zip)) {
    return false;
  }

  // Update user's shipping information.
  $db = connect_db();
  $q = "UPDATE Customers SET cust_name=?, cust_address=?, cust_city=?, cust_state=?, cust_zip=? WHERE cust_id=?";
  $update = $db->prepare($q);
  $update->bind_param("ssssss", $name, $addr, $city, strtoupper($state), $zip, $_SESSION['user']);
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
