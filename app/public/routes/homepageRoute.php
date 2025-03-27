<?php
require_once __DIR__ . '/../controllers/RestaurantController.php';
require_once __DIR__ . '/../controllers/DanceController.php';

$restaurantController = new RestaurantController();
$danceController = new DanceController();

$restaurants = $restaurantController->getAllRestaurants(); // Make sure this works
$artists = $danceController->getAllDanceArtists();
$danceFriday = $danceController->getDanceAtFriday();
$danceSaturday = $danceController->getDanceAtSaturday();
$danceSunday = $danceController->getDanceAtSunday();

require __DIR__ . '/../views/pages/home.php';
