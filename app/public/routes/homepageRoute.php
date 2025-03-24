<?php
require_once __DIR__ . '/../controllers/RestaurantController.php';
require_once __DIR__ . '/../controllers/DanceController.php';

// Instantiate controllers
$restaurantController = new RestaurantController();
$restaurants = $restaurantController->getAllRestaurants();

$danceController = new DanceController();
$danceFriday = $danceController->getDanceAtFriday();
$danceSaturday = $danceController->getDanceAtSaturday();
$danceSunday = $danceController->getDanceAtSunday();

// Load the homepage view, passing the variables
require __DIR__ . '/../views/pages/home.php';
?>
