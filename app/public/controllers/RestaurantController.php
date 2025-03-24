<?php
require_once __DIR__ . '/../models/RestaurantModel.php';

class RestaurantController {
    private $model;

    public function __construct() {
        $this->model = new RestaurantModel();
    }

    public function showRestaurants() {
        $restaurants = $this->model->getRestaurants();
        require __DIR__ . '/../views/pages/restaurants.php';
    }

    public function getAllRestaurants() {
        return $this->model->getRestaurants();
    }

    public function showSlots($restaurantID) {
        $slots = $this->model->getSlots($restaurantID);
        echo json_encode($slots);
    }

    public function reserve() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userID = $_POST["userID"];
            $restaurantID = $_POST["restaurantID"];
            $slotID = $_POST["slotID"];
            $adults = $_POST["adults"];
            $children = $_POST["children"];

            $this->model->reserveTable($userID, $restaurantID, $slotID, $adults, $children);
            header("Location: /restaurants?success=1");
        }
    }
}
?>
