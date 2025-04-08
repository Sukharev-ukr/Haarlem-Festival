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

    private function getAuthenticatedUserID() {
        $userID = $_SESSION['user']['userID'] ?? null;
        if (!$userID) {
            header("Location: /login");
            exit;
        }
        return $userID;
    }
    
    private function validateAndConvertDate($dateStr, $restaurantID) {
        $dateObj = DateTime::createFromFormat('Y-m-d', $dateStr);
        if (!$dateObj) {
            $_SESSION['reservation_error'] = "Please select a time slot.";
            header("Location: /restaurant?restaurantID=" . $restaurantID);
            exit;
        }
        return $dateObj->format('Y-m-d');
    }
    
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
    
    private function validateGroupSize($data) {
        $maxGuests = 20;
        $totalGuests = (int)$data['adults'] + (int)$data['children'];
        if ($totalGuests > $maxGuests) {
            $_SESSION['reservation_error'] = "For groups larger than $maxGuests people, please contact the restaurant directly.";
            header("Location: /restaurant?restaurantID=" . $data['restaurantID']);
            exit;
        }
    }
    
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

