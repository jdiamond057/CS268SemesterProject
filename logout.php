<?php
// Remove all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Redirect back to homepage
header("Location: index.html");
exit;