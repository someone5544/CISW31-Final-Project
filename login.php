<?php

  require('inc/session.php');
  if(user_logged_in()) {
    // User is logged in, no need to log in again.
	header('Location: index.php');
	exit;
  }
  if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
	// Posting to the page, process the login.
	if(log_in_user($_POST['email'], $_POST['password'])) {
		// Logged in fine, go to main page.
		header('Location: index.php');
		exit;
	}
	else {
		$error = "Invalid information was provided.";
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
      <tr><td colspan="3" style="text-align: center"><input type="submit" value="Log In"></td></tr>
    </table>
    </form>
  </div>

<?php
  require('footer.php');
?>