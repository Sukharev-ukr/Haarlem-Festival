<?php
require_once(__DIR__ . "../../controllers/CartController.php");

Route::add('/api/cart', function() {
    session_start();
    header('Content-Type: application/json');
    $userId = $_SESSION['userID'] ?? null;

    if ($userId) {
        $cartController = new CartController();
        $cartItems = $cartController->getCartItems($userId);
        echo json_encode(['status' => 'success', 'data' => $cartItems]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    }
}, 'GET');

Route::add('/api/cart/remove', function() {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents('php://input'), true);
    $orderItemId = $input['orderItemId'] ?? null;

    if ($orderItemId) {
        $cartController = new CartController();
        if ($cartController->removeItem($orderItemId)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove item.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }
}, 'POST');

// Route to load the shopping cart page
Route::add("/shoppingCart", function() {
    require_once(__DIR__ . "/../views/pages/shoppingCart.php");
}, 'GET');