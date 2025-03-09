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
Route::add("/ticketSelection", function() {
    $danceID = $_GET['danceID'] ?? null;
    if ($danceID) {
        require_once(__DIR__ . "/../views/pages/ticketSelection.php");
    } else {
        echo "<h3>Dance ID not found.</h3>";
    }
}, 'GET');

// API Route to add tickets to cart
Route::add('/api/addToCart', function() {
    header('Content-Type: application/json');

    // Ensure session is started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $userId = $_SESSION['userID'] ?? null;  // Ensure user is logged in

    // Check if user is logged in
    if (!$userId) {
        http_response_code(401);  // Unauthorized
        echo json_encode([
            'status' => 'error',
            'message' => 'User not logged in.'
        ]);
        exit;
    }

    // Validate input
    if (isset($input['danceID'], $input['tickets']) && is_array($input['tickets'])) {
        $cartController = new CartController();

        // Use the addTicketsToCart method since it accepts parameters
        $result = $cartController->addToCart($userId, $input['danceID'], $input['tickets']);

        if ($result) {
            http_response_code(200);  // OK
            echo json_encode([
                'status' => 'success',
                'message' => 'Tickets added to cart successfully!'
            ]);
        } else {
            http_response_code(500);  // Internal Server Error
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to add tickets to cart.'
            ]);
        }
    } else {
        http_response_code(400);  // Bad Request
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid input data.'
        ]);
    }
}, 'POST');
