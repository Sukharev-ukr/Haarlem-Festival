<?php

require_once(__DIR__ . "../../controllers/DanceController.php");
require_once(__DIR__ . "../../controllers/CartController.php");

// RESTful API Route for Ticket Selection
Route::add('/api/tickets', function() {
    header('Content-Type: application/json');

    $danceID = $_GET['danceID'] ?? null;

    if ($danceID) {
        $danceController = new DanceController();
        $ticketDetails = $danceController->getTicketDetails($danceID);

        if ($ticketDetails) {
            echo json_encode([
                'status' => 'success',
                'data' => $ticketDetails
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'status' => 'error',
                'message' => 'No tickets found for the provided Dance ID.'
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Dance ID not provided.'
        ]);
    }
}, 'GET');

// Route to load the ticket selection page
Route::add("/ticketSelection", function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user']['userID'])) {
        header("Location: /login"); // or whatever your login page is
        exit;
    }

    $danceID = $_GET['danceID'] ?? null;
    if ($danceID) {
        require_once(__DIR__ . "/../views/pages/ticketSelection.php");
    } else {
        echo "<h3>Dance ID not found.</h3>";
    }
}, 'GET');


// API Route to add tickets to cart
Route::add('/api/addToCart', function() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    header('Content-Type: application/json');

    $userId = $_SESSION['user']['userID'] ?? null;
    if (!$userId) {
        http_response_code(401);
        echo json_encode([
            'status' => 'error',
            'message' => 'User not logged in.'
        ]);
        return;
    }

    $input = json_decode(file_get_contents('php://input'), true);
    if (!isset($input['danceID'], $input['tickets']) || !is_array($input['tickets'])) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid input data.'
        ]);
        return;
    }

    $cartController = new CartController();
    $cartController->addToCart($userId, $input['danceID'], $input['tickets']); // ✅ this method already echoes
}, 'POST');




