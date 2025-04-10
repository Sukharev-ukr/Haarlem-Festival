<?php

require_once(__DIR__ . ("../../models/CartModel.php"));
    class CartController {
        private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

    public function addToCart($userId, $danceID, $tickets) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    

        $userId = $_SESSION['user']['userID'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }
    
        if (!$data) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request data']);
            return;
        }
    
        $danceID = $data['danceID'] ?? null;
        $tickets = $data['tickets'] ?? [];
    
        if (!$danceID || empty($tickets)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing danceID or tickets']);
            return;
        }
    
        try {
            $result = $this->cartModel->addTicketsToCart($userId, $danceID, $tickets);
    
            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Tickets added to cart']);
            } else {
                http_response_code(500);
                echo json_encode(['status' => 'error', 'message' => 'Failed to add tickets to cart']);
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Server error']);
        }
    }
    

    //Get order in shopping cart
    public function getCartItems($userId) {
        $cartItems = $this->cartModel->getCartItems($userId);
    
        foreach ($cartItems as &$item) {
            if (empty($item['danceDate']) && empty($item['sessionDate']) && empty($item['reservationDate'])) {
                $item['reservationDate'] = date('Y-m-d');
            }
        }
        unset($item); // clear reference
        return $cartItems;
    }
    
    
    //Remove order in shopping cart
    public function removeItem($orderItemId) {
        return $this->cartModel->removeOrderItem($orderItemId);
    }
}