<?php
require_once(__DIR__ . "/../models/AdminModel.php");

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

    // Fetch users for dashboard
    public function getUsers() {
        $search = $_GET['search'] ?? "";
        $sortColumn = $_GET['sort'] ?? "userID";
        $sortOrder = $_GET['order'] ?? "ASC";
        return $this->adminModel->getUsers($search, $sortColumn, $sortOrder);
    }

    // Handle User CRUD
    public function addUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->adminModel->addUser($data['userName'], $data['Email'], $data['password'], $data['role'])) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }

    public function updateUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->adminModel->updateUser($data['userID'], $data['userName'], $data['Email'], $data['role'])) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }

    public function deleteUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        if ($this->adminModel->deleteUser($data['userID'])) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }
    ////////////////////////////////////////////////////////////////////////////////Get Dance
    
    // Fetch all Dance events
    public function getDanceEvents() {
        try {
            $events = $this->adminModel->getDanceEvents();
            
            // ✅ Ensure we return only the array of dance events (not wrapped in 'success' key)
            return $events; 
        } catch (Exception $e) {
            return []; // Return empty array if there's an error
        }
    }

    ////////////////////////////////////////////////////////////////////////////////Create new dance event
    public function createDanceEvent() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data['location'], $data['startTime'], $data['endTime'], $data['day'], $data['danceDate'], $data['danceCapacity'], $data['duration'])) {
                throw new Exception("All fields are required.");
            }
    
            // Ensure duration is in HH:MM:SS format
            $duration = gmdate("H:i:s", strtotime($data['duration']));
    
            $result = $this->adminModel->createDanceEvent(
                $data['location'],
                $data['startTime'],
                $data['endTime'],
                $data['day'],
                $data['danceDate'],
                (int) $data['danceCapacity'],
                $duration 
            );
    
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
    

    // Update an existing Dance event
    public function updateDanceEvent() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);
    
            if (!isset($data['danceID'], $data['location'], $data['startTime'], $data['endTime'], $data['day'], $data['danceDate'], $data['danceCapacity'])) {
                throw new Exception("All fields are required.");
            }
    
            $result = $this->adminModel->updateDanceEvent(
                $data['danceID'],
                $data['location'],
                $data['startTime'],
                $data['endTime'],
                $data['day'],
                $data['danceCapacity'],
                $data['danceDate']
            );
    
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    // Delete a Dance event
    public function deleteDanceEvent($danceID) {
        try {
            if (empty($danceID)) {
                throw new Exception("Dance ID is required.");
            }
    
            $success = $this->adminModel->deleteDanceEvent($danceID);
    
            if ($success) {
                return ["success" => true, "message" => "Dance event deleted successfully."];
            } else {
                throw new Exception("Failed to delete dance event.");
            }
        } catch (Exception $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    } 
}
?>
