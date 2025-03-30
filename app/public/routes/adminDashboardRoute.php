<?php
require_once(__DIR__ . "/../controllers/AdminController.php");

$adminController = new AdminController();
// Admin Dashboard Page
Route::add('/adminDashBoard', function() {

    require(__DIR__ . "../../views/pages/adminDashBoard.php");
}, 'GET');

// API: Fetch users with search, sorting, and filtering
Route::add('/api/admin/users', function() use ($adminController) {
    header('Content-Type: application/json');
    echo json_encode($adminController->getUsers());
}, 'GET');

// API: Add a new user
Route::add('/api/admin/users/add', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->createUser();
}, 'POST');
// API: Update user details
Route::add('/api/admin/users/update', function() use ($adminController) {
    header('Content-Type: application/json');
    $adminController->updateUser();
}, 'POST');

// API: Delete user
Route::add('/api/admin/users/delete', function() use ($adminController) {
    header('Content-Type: application/json');
    $adminController->deleteUser();
}, 'POST');


//////////////////////////////////////////////////////////////////////////////////////////////////////////Dance
Route::add('/api/admin/danceEvents', function() {
    header('Content-Type: application/json');

    $adminController = new AdminController();
    echo json_encode($adminController->getDanceEvents()); // ✅ Returns array, not wrapped in {success: true, data: [...]}
}, 'GET');

Route::add('/api/admin/addDanceEvent', function() {
    header('Content-Type: application/json');
    $adminController = new AdminController();
    $adminController->createDanceEvent();
}, 'POST');


Route::add('/api/admin/updateDanceEvent', function() {
    header('Content-Type: application/json');

    $adminController = new AdminController();
    $adminController->updateDanceEvent();

}, 'PUT');

Route::add('/api/admin/deleteDanceEvent', function() use ($adminController) {
    header('Content-Type: application/json');
    $input = json_decode(file_get_contents("php://input"), true);

    if (!isset($input['danceID']) || empty($input['danceID'])) {
        echo json_encode(["success" => false, "message" => "Dance ID is required."]);
        exit;
    }

    echo json_encode($adminController->deleteDanceEvent($input['danceID']));
}, 'DELETE');

//////////////////////////////////////////////////////////////////////////////Artistssssssssssssssssssssssssssss
Route::add('/api/admin/artists', function() use ($adminController) {
    header('Content-Type: application/json');

    try {
        $response = $adminController->getArtists();
        if (!isset($response['success'])) {
            throw new Exception("Invalid response format.");
        }

        echo json_encode($response);
    } catch (Exception $e) {
        error_log("Route Error: " . $e->getMessage());
        echo json_encode(["success" => false, "message" => "Server error: " . $e->getMessage()]);
    }
}, 'GET');

Route::add('/api/admin/artists', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->getArtists();
}, 'GET');

Route::add('/api/admin/addArtist', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->createArtist();
}, 'POST');

Route::add('/api/admin/updateArtist', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->updateArtist();
}, 'POST');

Route::add('/api/admin/deleteArtist', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->deleteArtist();
}, 'DELETE');

////////////////////////////////////////////////////////////////////////////////Dance-Artist
Route::add('/api/admin/assignments', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->getDanceArtistAssignments();
}, 'GET');

Route::add('/api/admin/assignArtist', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->assignArtistToDance();
}, 'POST');

Route::add('/api/admin/updateAssignment', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->updateDanceArtistAssignment();
}, 'PUT');

Route::add('/api/admin/deleteAssignment', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    $controller->deleteDanceArtistAssignment();
}, 'DELETE');

Route::add('/api/admin/danceLocations', function() {
    header('Content-Type: application/json');
    $controller = new AdminController();
    echo json_encode($controller->getDanceLocationsByDate($_GET['date'] ?? ''));
}, 'GET');

?>
