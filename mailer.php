<?php
  require('header.php');
?>
  <!-- page content -->
  <div class="content">
  
<?php
// ----------------------------------------- 
//  The Web Help .com
// ----------------------------------------- 
// remember to replace your@email.com with your own email address lower in this code.

// load the variables form address bar
$name = $_REQUEST["name"];
$subject = $_REQUEST["subject"];
$message = $_REQUEST["message"];
$from = $_REQUEST["from"];
$verif_box = $_REQUEST["verif_box"];

// remove the backslashes that normally appears when entering " or '
$name = stripslashes($name); 
$message = stripslashes($message); 
$subject = stripslashes($subject); 
$from = stripslashes($from); 

// check to see if verificaton code was correct
if(md5($verif_box).'a4xn' == $_COOKIE['tntcon']){
	// if verification code was correct send the message and show this page
	$message = "Name: ".$name."\n".$message;
	$message = "From: ".$from."\n".$message;
	mail("email@my-site-here.com", 'Online Form: '.$subject, $_SERVER['REMOTE_ADDR']."\n\n".$message, "From: $from");
	// delete the cookie so it cannot sent again by refreshing this page
	setcookie('tntcon','');
} else {
	// if verification code was incorrect then return to contact page and show error
	header("Location:".$_SERVER['HTTP_REFERER']."?subject=$subject&from=$from&message=$message&wrong_code=true");
	exit;
}
?>
  
  
  
  
    </div>
<?php
  require('footer.php');
?>