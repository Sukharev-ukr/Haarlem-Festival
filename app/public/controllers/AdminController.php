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
    public function createUser() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['userName'], $data['email'], $data['password'], $data['role'])) {
                throw new Exception("All fields are required.");
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }

            if (strlen($data['password']) < 6) {
                throw new Exception("Password must be at least 6 characters long.");
            }

            $result = $this->adminModel->addUser(
                $data['userName'],
                $data['email'],
                $data['password'],
                $data['role']
            );

            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
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

    ////////////////////////////////////////////////////////////////////////////////////Artist
    public function getArtists() {
        try {
            $result = $this->adminModel->getArtists();

            if (!$result['success']) {
                throw new Exception($result['message']);
            }

            return $result;
        } catch (Exception $e) {
            error_log("Controller Error: " . $e->getMessage());
            return ["success" => false, "message" => "Error fetching artists: " . $e->getMessage()];
        }
    }

     // Create a new artist
     public function createArtist() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['name'], $data['style'], $data['description'], $data['origin'])) {
                throw new Exception("All fields are required.");
            }

            echo json_encode($this->adminModel->addArtist(
                $data['name'], 
                $data['style'], 
                $data['description'], 
                $data['origin']
            ));
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    // Update an artist
    public function updateArtist() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['artistID'], $data['name'], $data['style'], $data['description'], $data['origin'])) {
                throw new Exception("All fields are required.");
            }

            echo json_encode($this->adminModel->updateArtist(
                $data['artistID'], 
                $data['name'], 
                $data['style'], 
                $data['description'], 
                $data['origin']
            ));
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    // Delete an artist
    public function deleteArtist() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['artistID'])) {
                throw new Exception("Artist ID is required.");
            }

            echo json_encode($this->adminModel->deleteArtist($data['artistID']));
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
/////////////////////////////////////////////////////////////////////Dance-Arist

 // Get all Dance-Artist Assignments
 public function getDanceArtistAssignments() {
    echo json_encode($this->adminModel->getDanceArtistAssignments());
}

// Assign a Dance to an Artist
public function assignArtistToDance() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['danceID'], $data['artistID'])) {
            throw new Exception("All fields are required.");
        }

        echo json_encode($this->adminModel->assignArtistToDance($data['danceID'], $data['artistID']));
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// Update an assignment
public function updateDanceArtistAssignment() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['danceID'], $data['artistID'], $data['newDanceID'], $data['newArtistID'])) {
            throw new Exception("All fields are required.");
        }

        echo json_encode($this->adminModel->updateDanceArtistAssignment(
            $data['danceID'], $data['artistID'], $data['newDanceID'], $data['newArtistID']
        ));
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// Delete an assignment
public function deleteDanceArtistAssignment() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['danceID'], $data['artistID'])) {
            throw new Exception("All fields are required.");
        }

        echo json_encode($this->adminModel->deleteDanceArtistAssignment($data['danceID'], $data['artistID']));
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

public function getDanceLocationsByDate($date) {
    try {
        if (empty($date)) {
            throw new Exception("Date is required.");
        }

        $locations = $this->adminModel->fetchDanceLocationsByDate($date);
        return ["success" => true, "data" => $locations];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}
}
?>
