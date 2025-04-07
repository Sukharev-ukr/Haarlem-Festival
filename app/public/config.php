<?php
// config.php

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define a helper function to check if a user is logged in
function ensure_logged_in() {
    // If the user is not logged in, redirect them to the login page
    if (!isset($_SESSION['user'])) {
        header("Location: /user/login");
        exit;
    }
}

// Optionally, you can add more configuration items here (DB connection settings, etc.)
?>
