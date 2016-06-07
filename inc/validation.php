<?php
function valid_state($state) {
  // Validate state input.
  // State should only be 2 characters.
  
  if(strlen($state) == 2)
    return true;
  else
    return false;
}

function valid_zip($zip) {
  // Validate ZIP input.
  // ZIP should be 5 characters and only numbers.
  
  if(strlen($zip) == 5 && is_numeric($zip))
    return true;
  else
    return false;
}

function valid_email($email) {
  // Validate Email input.
  // Email should contain an @ symbol.
  
  if(strpos($email, "@") !== false)
    return true;
  else
    return false;
}
?>
