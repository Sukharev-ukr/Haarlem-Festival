<?php

require_once(__DIR__ . ("../../models/CartModel.php"));
    class CartController {
        private $cartModel;

    public function __construct() {
        $this->cartModel = new CartModel();
    }

     public function addToCart() {
        // Ensure session is started only once
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['userID'] ?? null;
        $data = json_decode(file_get_contents("php://input"), true);

        // Validate user login
        if (!$userId) {
            http_response_code(401);
            echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
            return;
        }

        // Validate request data
        if (!$data) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Invalid request data']);
            return;
        }

        $danceID = $data['danceID'] ?? null;
        $tickets = $data['tickets'] ?? [];

        // Validate danceID and tickets
        if (!$danceID || empty($tickets)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing danceID or tickets']);
            return;
        }

        try {
            // Add tickets to cart
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
}