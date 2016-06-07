<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
  require('inc/session.php');
  require('inc/account.php');
  if(user_logged_in()) {
    // User is logged in, no need to log in again.
	header('Location: index.php');
	exit;
  }
  if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
	// Posting to the page, process the login or registration.
	if($_POST['action'] == "Register") {
		// Register new account.
		if(create_user($_POST['email'], $_POST['password'])) {
			// Created account.
			$error = "Created your account, please log in.";
		}
		else {
			$error = "Could not create your account with the information given, please try again.";
		}
	}
	else {
		// Log in user.
		if(log_in_user($_POST['email'], $_POST['password'])) {
			// Logged in fine, go to main page.
			header('Location: index.php');
			exit;
		}
		else {
			$error = "Invalid information was provided.";
		}
	}
  }
  require('header.php');
?>
  <!-- page content -->
  <div class="content">
    <h2>Log In</h2><br>
    <form action="login.php" method="post">
    <table align="center">
<?php
if(isset($error)) {
  echo "<tr><td colspan=\"3\"><b>".$error."</b></td></tr>\n";
}
?>
      <tr><td>E-Mail:</td><td>&nbsp;</td><td><input type="text" maxlength="100" name="email"></td></tr>
      <tr><td>Password:</td><td>&nbsp;</td><td><input type="password" name="password"></td></tr>
      <tr><td colspan="3" style="text-align: center"><input type="submit" name="action" value="Log In">&nbsp;<input type="submit" name="action" value="Register"></td></tr>
    </table>
    </form>
  </div>

<?php
  require('footer.php');
?>