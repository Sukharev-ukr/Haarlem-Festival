<?php
// Load the Restaurant and Reservation controllers
require_once(__DIR__ . '/../controllers/RestaurantController.php');
require_once(__DIR__ . '/../controllers/ReservationController.php');

// Route 1: GET /restaurants
// Shows all restaurants on the overview page
// e.g. http://localhost/restaurants

Route::add('/restaurants', function () {
    $controller = new RestaurantController();
    $controller->showRestaurants();
});

// Route 2: GET /restaurants/slots?restaurantID=5
// Returns all available reservation slots for a given restaurant
// Used to dynamically load time slots via JavaScript or AJAX
// This endpoint was implemented to support more dynamic UX

Route::add('/restaurants/slots', function () {
    $restaurantID = $_GET['restaurantID'] ?? null; // Get ID from the URL query
    if (!$restaurantID) {
        echo json_encode(["error" => "Missing restaurant ID"]);
        return;
    }
    
    $controller = new RestaurantController();
    $controller->showSlots($restaurantID);
});

// Route 3: GET /restaurant?restaurantID=5
// Shows the restaurant detail page with reservation form
// e.g. http://localhost/restaurant?restaurantID=1

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

// Route 4: POST /reservation/make
// Handles form submission when a user makes a reservation
// e.g. form action="/reservation/make" method="POST"

Route::add('/reservation/make', function () {
    $controller = new ReservationController();
    $controller->reserve();
}, 'post');
