<?php
session_start();

// Sab session variables clear kar do
$_SESSION = array();

// Session destroy kar do
session_destroy();

// User ko login page ya dashboard pe bhejo
header("Location: login.php");  // Yahan apne login ya dashboard ka URL daal do
exit();
?>
