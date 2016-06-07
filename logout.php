<?php
// Log the user out and destroy the session.

require('inc/session.php');

end_session();
// Redirect user to home page.
header('Location: index.php');
?>
