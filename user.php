<?php
  
  require('inc/session.php');
  if(!user_logged_in()) {
	  // Check if user is logged in.
	  header('Location: login.php');
	  exit;
  }
  require('header.php');
  require('inc/account.php');
  
  if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
	  // Posting to page, store information based on action.
	  if($_POST['action'] == "password") {
		  // Modify user's password.
		  if(!update_password($_POST['cust_old_password'], $_POST['cust_new_password'])) {
			  $error = "Error while updating your password, please try again.";
		  }
		  else {
			  $error = "Your password was updated.";
		  }
	  }
	  elseif($_POST['action'] == "personal_info") {
		  // Modify user's personal information.
		  if(!update_information($_POST['cust_name'], $_POST['cust_address'], $_POST['cust_city'], $_POST['cust_state'], $_POST['cust_zip'], $_POST['cust_email'])) {
			  $error = "Error while updating your personal information, please try again.";
		  }
		  else {
			  $error = "Your personal information was updated.";
		  }
	  }
	  else {
		  $error = "Unknown action.";
	  }
  }
  
?>
  <!-- page content -->
  <div class="content">
  	<h2>My Account</h2><br>
    <table align="center">
<?php
if(isset($error)) {
	echo "<tr><td colspan=\"3\" style=\"text-align: center\"><b>".$error."</b></td></tr>\n";
}
$cust_info = load_user_info();
?>
      <form action="user.php" method="post">
      <input type="hidden" name="action" value="password">
      <tr><td colspan="3"><span style="font-size: large"><b>Change Password</b></span></td></tr>
      <tr><td>Old Password:</td><td>&nbsp;</td><td><input type="password" name="cust_old_password" size="40"></td></tr>
      <tr><td>New Password:</td><td>&nbsp;</td><td><input type="password" name="cust_new_password" size="40"></td></tr>
      <tr><td colspan="3" style="text-align: center"><input type="submit" value="Update Password"></td></tr>
      </form>
      <tr><td colspan="3">&nbsp;</td></tr>
      <form action="user.php" method="post">
      <input type="hidden" name="action" value="personal_info">
      <tr><td colspan="3"><span style="font-size: large"><b>Edit Personal Information</b></span></td></tr>
      <tr><td>E-Mail:</td><td>&nbsp;</td><td><input type="text" name="cust_email" value="<?=htmlspecialchars($cust_info['cust_email']); ?>" size="20" maxlength="100"></td></tr>
      <tr><td>Name:</td><td>&nbsp;</td><td><input type="text" name="cust_name" value="<?=htmlspecialchars($cust_info['cust_name']); ?>" size="20" maxlength="50"></td></tr>
      <tr><td>Address:</td><td>&nbsp;</td><td><input type="text" name="cust_address" value="<?=htmlspecialchars($cust_info['cust_address']); ?>" size="40" maxlength="50"></td></tr>
      <tr><td>City:</td><td>&nbsp;</td><td><input type="text" name="cust_city" value="<?=htmlspecialchars($cust_info['cust_city']); ?>" size="40" maxlength="50"></td></tr>
      <tr><td>State:</td><td>&nbsp;</td><td><input type="text" name="cust_state"  value="<?=htmlspecialchars($cust_info['cust_state']); ?>" size="2" maxlength="2"></td></tr>
      <tr><td>ZIP:</td><td>&nbsp;</td><td><input type="text" name="cust_zip" value="<?=htmlspecialchars($cust_info['cust_zip']); ?>" maxlength="5" size="5"></td></tr>
      <tr><td colspan="3" style="text-align: center"><input type="submit" value="Save Information"></td></tr>
      </form>
    </table>
    <br><br>
    <p style="text-align: center"><a href="orders.php" class="btn btn-primary btn-md">My Orders</a></p>
  </div>
<?php
  require('footer.php');
?>