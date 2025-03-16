<?php
require_once(__DIR__ . '/../controllers/RestaurantController.php');

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

Route::add('/restaurants/reserve', function () {
    $controller = new RestaurantController();
    $controller->reserve();
}, 'post');