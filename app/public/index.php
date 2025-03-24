<?php
require_once(__DIR__ . "/lib/env.php");
require_once(__DIR__ . "/lib/error_reporting.php");
require_once __DIR__ . '/vendor/autoload.php';

session_start();

// Include the Route class definition first
require_once(__DIR__ . "/lib/Route.php");

// Now include your route files
require_once(__DIR__ . "/routes/index.php");
require_once(__DIR__ . "/routes/user.php");
require_once(__DIR__ . "/routes/restaurants.php");
require_once(__DIR__ . "/routes/DancePageROute.php");
require_once(__DIR__ . "/routes/detailArtistPage.php");
require_once(__DIR__ . "/routes/ticketSelectionRoute.php");
require_once(__DIR__ . "/routes/shoppingCartRoute.php");
require_once __DIR__ . '/routes/homepageRoute.php';
require_once(__DIR__ . "/routes/adminDashboardRoute.php");
require_once(__DIR__ . "/routes/personalProgramRoute.php");

// Set a default path-not-found handler for debugging
Route::pathNotFound(function($path) {
    echo "DEBUG: No route matched for path: " . htmlspecialchars($path);
});

// Run the router
Route::run();
