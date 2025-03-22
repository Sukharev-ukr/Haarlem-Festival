<?php
require_once "models/ReservationModel.php";

class ReservationController {
    private $model;

    public function __construct() {
        $this->model = new ReservationModel();
    }

    public function getAvailableSessions($restaurantID) {
    $slots = $this->model->fetchSessionsByRestaurant($restaurantID);
    return $slots;
}

    public function getRestaurantByID($restaurantID) {
        return $this->model->getRestaurantByID($restaurantID);
    }

    // public function reserve() {
    //     $userID = $this->getLoggedInUserID();
    //     if (!$userID) {
    //         header("Location: /login");
    //         exit;
    //     }
    
    //     $data = $this->getPostData();
    //     $errors = $this->validateReservationFields($data);
    
    //     if (!empty($errors)) {
    //         // Return view with errors
    //         return;
    //     }
    
    //     $orderID = $this->model->getOrCreateOrder($userID);
    //     $this->model->createReservation($data, $orderID, $userID);
    
    //     header("Location: /cart");
    //     exit;
    // }
      
}
?>

