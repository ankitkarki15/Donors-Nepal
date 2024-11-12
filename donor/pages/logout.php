<?php
// Start output buffering to prevent any premature output
ob_start();
// session_start();

// Destroy the session
session_unset();
session_destroy();

// Redirect to login page
// header("Location: donorlogin.php");
exit(); // Always use exit after header redirection

// Ensure no further output is sent
ob_end_flush();
?>
