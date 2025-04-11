<?php
// Load the model responsible for restaurant data
require_once __DIR__ . '/../models/RestaurantModel.php';

class RestaurantController {
    private $model;

    // Constructor: initialize the model so it can be used throughout this controller
    public function __construct() {
        $this->model = new RestaurantModel();
    }

    // Displays the page that lists all restaurants
    public function showRestaurants() {
        $restaurants = $this->model->getRestaurants();
        require __DIR__ . '/../views/pages/restaurants.php';
    }

    // Returns all restaurants (for use in other parts of the app, like AJAX or view logic)
    public function getAllRestaurants() {
        return $this->model->getRestaurants();
    }

    // Outputs available time slots for a specific restaurant in JSON format
    public function showSlots($restaurantID) {
        $slots = $this->model->getSlots($restaurantID);
        echo json_encode($slots);
    }

    // Handles a reservation directly
    public function reserve() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userID = $_POST["userID"];
            $restaurantID = $_POST["restaurantID"];
            $slotID = $_POST["slotID"];
            $adults = $_POST["adults"];
            $children = $_POST["children"];

            // Directly calls the model to store the reservation
            $this->model->reserveTable($userID, $restaurantID, $slotID, $adults, $children);

            // Redirect back to restaurant list with success message
            header("Location: /restaurants?success=1");
        }
    }

    // Fetches and returns a restaurant's detailed info
    public function showRestaurantDetails($restaurantID) {
        return $this->model->getRestaurantByID($restaurantID);
    }
    
    // Returns restaurants that include an image path for visual display (e.g., on dining page)
    public function getAllDiningRestaurants()
{
    // Assuming $this->model is an instance of RestaurantModel
    return $this->model->getRestaurantsWithPicture();
}
    
    
}
?>
