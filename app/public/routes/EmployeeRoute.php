<?php
require_once(__DIR__ . "/../controllers/EmployeeController.php");

Route::add('/api/tickets/scan', function() {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents("php://input"), true);
    $ticketID = $input['ticketID'] ?? null;

    if ($ticketID) {
        $controller = new EmployeeController();
        echo json_encode($controller->scanTicket($ticketID));
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing ticket ID.']);
    }
}, 'POST');

Route::add('/scanner', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    
    if (!isset($_SESSION['user'])) {
        header("Location: /user/login"); // send them to login page
        exit;
    }
    
    $userId = $_SESSION['user']['userID'];
    require_once(__DIR__ . '/../views/pages/scannerPage.php');
}, 'GET');
