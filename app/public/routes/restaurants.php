<?php
require_once(__DIR__ . '/../controllers/RestaurantController.php');
require_once(__DIR__ . '/../controllers/ReservationController.php');

Route::add('/restaurants', function () {
    $controller = new RestaurantController();
    $controller->showRestaurants();
});

Route::add('/restaurants/slots', function () {
    $restaurantID = $_GET['restaurantID'] ?? null; // Get ID from the URL query
    if (!$restaurantID) {
        echo json_encode(["error" => "Missing restaurant ID"]);
        return;
    }
    
    $controller = new RestaurantController();
    $controller->showSlots($restaurantID);
});

Route::add('/restaurant', function () {
    $restaurantID = $_GET['restaurantID'] ?? null;
    if (!$restaurantID) {
        echo "Invalid restaurant ID.";
        return;
    }

    $controller = new RestaurantController();
    $restaurant = $controller->showRestaurantDetails($restaurantID);

    if (!$restaurant) {
        echo "Restaurant not found.";
        return;
    }

    require "views/pages/detailRestaurantPage.php";
});

// Route::add('/restaurants/reserve', function () {
//     $controller = new ReservationController();
//     $controller->reserve();
// }, 'post');