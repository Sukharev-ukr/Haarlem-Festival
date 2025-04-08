<?php
require_once __DIR__ . '/../controllers/RestaurantController.php';
require_once __DIR__ . '/../controllers/DanceController.php';

$restaurantController = new RestaurantController();
$danceController = new DanceController();

$diningRestaurants = $restaurantController->getAllDiningRestaurants();
$restaurants = $restaurantController->getAllRestaurants();
$artists = $danceController->getAllDanceArtists();
$danceFriday = $danceController->getDanceAtFriday();
$danceSaturday = $danceController->getDanceAtSaturday();
$danceSunday = $danceController->getDanceAtSunday();
$artists = $danceController->getAllDanceArtists();

require __DIR__ . '/../views/pages/home.php';
