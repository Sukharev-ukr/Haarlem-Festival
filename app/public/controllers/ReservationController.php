<?php
// Include the models needed for reservations and cart operations
require_once "models/ReservationModel.php";
require_once "models/CartModel.php";

class ReservationController {
    private $model;

    // Constructor: sets up the ReservationModel so we can use it throughout the controller
    public function __construct() {
        $this->model = new ReservationModel();
    }

    // Fetches all available time slots for a given restaurant
    public function getAvailableSessions($restaurantID) {
    $slots = $this->model->fetchSessionsByRestaurant($restaurantID);
    return $slots;
}

    // Fetches restaurant details by ID (e.g., name, address, pricing)
    public function getRestaurantByID($restaurantID) {
        return $this->model->getRestaurantByID($restaurantID);
    }

    // Gets the logged-in user's ID, redirects to login page if not authenticated
    private function getAuthenticatedUserID() {
        $userID = $_SESSION['user']['userID'] ?? null;
        if (!$userID) {
            header("Location: /login");
            exit;
        }
        return $userID;
    }
    
    // Validates and converts the reservation date from form into correct format
    private function validateAndConvertDate($dateStr, $restaurantID) {
        $dateObj = DateTime::createFromFormat('Y-m-d', $dateStr);
        if (!$dateObj) {
            $_SESSION['reservation_error'] = "Please select a time slot.";
            header("Location: /restaurant?restaurantID=" . $restaurantID);
            exit;
        }
        return $dateObj->format('Y-m-d');
    }
    
    // Collects and structures form data into an associative array for processing
    private function collectReservationData($convertedDate) {
        return [
            'restaurantID' => $_POST['restaurantID'],
            'slotID' => $_POST['slotID'],
            'fullName' => $_POST['fullName'],
            'phoneNumber' => $_POST['phoneNumber'],
            'email' => $_POST['email'] ?? '',
            'adults' => $_POST['adults'],
            'children' => $_POST['children'],
            'specialRequests' => $_POST['specialRequests'] ?? '',
            'reservationDate' => $convertedDate
        ];
    }
    
    // Checks if the total guest count exceeds a set limit (20)
    private function validateGroupSize($data) {
        $maxGuests = 20;
        $totalGuests = (int)$data['adults'] + (int)$data['children'];
        if ($totalGuests > $maxGuests) {
            $_SESSION['reservation_error'] = "For groups larger than $maxGuests people, please contact the restaurant directly.";
            header("Location: /restaurant?restaurantID=" . $data['restaurantID']);
            exit;
        }
    }
    
    // Checks if the selected time slot exists and has enough capacity for the reservation
    private function checkSlotCapacity($data) {
        $slotID = $data['slotID'];
        $stmt = $this->model->getDB()->prepare("SELECT capacity FROM RestaurantSlot WHERE slotID = ?");
        $stmt->execute([$slotID]);
        $slot = $stmt->fetch();
    
        if (!$slot) {
            $_SESSION['reservation_error'] = "Invalid time slot selected.";
            header("Location: /restaurant?restaurantID=" . $data['restaurantID']);
            exit;
        }
    
        $totalGuests = (int)$data['adults'] + (int)$data['children'];
        if ($totalGuests > (int)$slot['capacity']) {
            $_SESSION['reservation_error'] = "Sorry, not enough seats available for this time slot.";
            header("Location: /restaurant?restaurantID=" . $data['restaurantID']);
            exit;
        }
    }
    
    // Main method that handles form submission to make a reservation
    public function reserve() {
        $userID = $this->getAuthenticatedUserID();
        $convertedDate = $this->validateAndConvertDate($_POST['reservationDate'], $_POST['restaurantID']);
    
        $data = $this->collectReservationData($convertedDate);
    
        $this->validateGroupSize($data);
        $this->checkSlotCapacity($data);
    
        $pricing = $this->model->calculateReservationCosts(
            $data['restaurantID'], $data['adults'], $data['children']
        );
    
        $cartModel = new CartModel();
        $cartModel->addReservationToCart($userID, $data, $pricing);
    
        header("Location: /shoppingCart");
        exit;
    }
    
    
}

