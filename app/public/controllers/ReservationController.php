<?php
require_once "models/ReservationModel.php";
require_once "models/CartModel.php";

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

    private function getLoggedInUserID() {
        return $_SESSION['user']['userID'] ?? null;
    }
    
    private function getPostData() {
        return [
            'fullName' => $_POST['fullName'] ?? '',
            'phoneNumber' => $_POST['phoneNumber'] ?? '',
            'email' => $_POST['email'] ?? '',
            'adults' => $_POST['adults'] ?? 0,
            'children' => $_POST['children'] ?? 0,
            'specialRequests' => $_POST['specialRequests'] ?? '',
            'slotID' => $_POST['slotID'] ?? null,
            'reservationDate' => $_POST['reservationDate'] ?? null
        ];
    }
    
    private function validateReservationFields($data) {
        $errors = [];
    
        if (empty($data['fullName'])) $errors[] = "Full name is required";
        if (empty($data['phoneNumber'])) $errors[] = "Phone number is required";
        if (empty($data['slotID'])) $errors[] = "Please select a time slot";
        if (empty($data['reservationDate'])) $errors[] = "Please pick a reservation date";
    
        return $errors;
    }

    public function reserve() {
        $userID = $_SESSION['user']['userID'] ?? null;
        if (!$userID) {
            header("Location: /login");
            exit;
        }
    
        // 1. Get and convert the date first
        $inputDate = $_POST['reservationDate'] ?? null;

        // var_dump($inputDate);
        // exit;

        $dateObj = DateTime::createFromFormat('Y-m-d', $inputDate);
    
        if (!$dateObj) {
            echo "Invalid reservation date format";
            exit;
        }
    
        // 2. Then format it correctly
        $convertedDate = $dateObj->format('Y-m-d');
    
        // 3. Now safely populate $data with converted value
        $data = [
            'restaurantID' => $_POST['restaurantID'],
            'slotID' => $_POST['slotID'],
            'fullName' => $_POST['fullName'],
            'phoneNumber' => $_POST['phoneNumber'],
            'email' => $_POST['email'] ?? '',
            'adults' => $_POST['adults'],
            'children' => $_POST['children'],
            'specialRequests' => $_POST['specialRequests'] ?? '',
            'reservationDate' => $convertedDate  // ✅ fixed here
        ];
    
        // 4. Calculate reservation pricing
        $pricing = $this->model->calculateReservationCosts(
            $data['restaurantID'],
            $data['adults'],
            $data['children']
        );
    
        // 5. Add to cart
        $cartModel = new CartModel();
        $cartModel->addReservationToCart($userID, $data, $pricing);
    
        // 6. Redirect to shopping cart
        header("Location: /shoppingCart");
        exit;
    }
    
}

