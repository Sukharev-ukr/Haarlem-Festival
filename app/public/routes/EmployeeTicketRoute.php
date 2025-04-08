<?php
Route::add('/api/employee/tickets', function () {
    header('Content-Type: application/json');
    $controller = new EmployeeController();

    $username = $_GET['username'] ?? null;
    echo json_encode([
        "success" => true,
        "data" => $controller->getDanceTickets($username)
    ]);
}, 'GET');

Route::add('/api/employee/ticket/update', function () {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents("php://input"), true);
    $id = $input['danceTicketID'] ?? null;
    $status = $input['status'] ?? null;

    if ($id && $status) {
        $controller = new EmployeeController();
        $result = $controller->updateTicketStatus($id, $status);
        echo json_encode([
            "success" => $result
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Missing data"
        ]);
    }
}, 'POST');

Route::add('/employeeTickets', function () {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    
    if (!isset($_SESSION['user'])) {
        header("Location: /user/login"); // send them to login page
        exit;
    }
    
    $userId = $_SESSION['user']['userID'];
    require_once(__DIR__ . '/../views/pages/employeeTickets.php');
}, 'GET');
