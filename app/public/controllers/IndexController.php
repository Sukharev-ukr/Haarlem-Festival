<?php
// app_public/controllers/IndexController.php

class IndexController
{
    public function home()
{
    require_once __DIR__ . '/../controllers/RestaurantController.php';
    require_once __DIR__ . '/../controllers/DanceController.php';
    require_once __DIR__ . '/../controllers/LorentzController.php';

    $lorentzController = new LorentzController();
    $restaurantController = new RestaurantController();
    $danceController = new DanceController();
    
    $artists = $danceController->getAllDanceArtists(); 
    $diningRestaurants = $restaurantController->getAllDiningRestaurants();
    $restaurants = $restaurantController->getAllRestaurants();
    $danceFriday   = $danceController->getDancesByDate('2025-07-25');
    $danceSaturday = $danceController->getDancesByDate('2025-07-26');
    $danceSunday   = $danceController->getDancesByDate('2025-07-27');


    require_once __DIR__ . '/../views/pages/home.php';
}


    public function about()
    {
        echo "<h1>About Page</h1>";
        echo "<p>This is the about page.</p>";
    }
}
