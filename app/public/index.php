<?php
require_once(__DIR__ . "/lib/env.php");
require_once(__DIR__ . "/lib/error_reporting.php");
session_start();



require_once (__DIR__ . "/routes/passwordResetRoute.php");
require_once(__DIR__ . "/lib/Route.php");
require_once(__DIR__ . "/routes/index.php");
require_once(__DIR__ . "/routes/user.php");
require_once(__DIR__ . "/routes/restaurants.php");
require_once(__DIR__ . "/routes/DancePageROute.php");
require_once(__DIR__ . "/routes/detailArtistPage.php");
require_once(__DIR__ . "/routes/ticketSelectionRoute.php");

// Set a default path-not-found handler for debugging
Route::pathNotFound(function($path) {
    echo "DEBUG: No route matched for path: " . htmlspecialchars($path);
});

// Run the router
Route::run();


