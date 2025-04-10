<?php
require_once(__DIR__ . "/../models/AdminModel.php");

class AdminController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new AdminModel();
    }

        // Get Users API
    public function getUsers() {
        try {
            $search = $_GET['search'] ?? "";
            $sortColumn = $_GET['sort'] ?? "userID";
            $sortOrder = $_GET['order'] ?? "ASC";
            $result = $this->adminModel->getUsers($search, $sortColumn, $sortOrder);

            echo json_encode(["success" => true, "data" => $result]);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }

    // Add User API
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
                throw new Exception("Password must be at least 6 characters.");
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

    // Update User API
    public function updateUser() {
        try {
            $data = json_decode(file_get_contents("php://input"), true);

            if (!isset($data['userID'], $data['userName'], $data['email'], $data['role'])) {
                throw new Exception("All fields are required.");
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }

            $result = $this->adminModel->updateUser($data['userID'], $data['userName'], $data['email'], $data['role']);
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
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
            // ✅ Get form data via $_POST
            $name = $_POST['name'];
            $style = $_POST['style'];
            $description = $_POST['description'];
            $origin = $_POST['origin'];
    
            $picturePath = null;
    
            // ✅ Handle picture upload
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('artist_') . '.' . $ext;
    
                $uploadDir = __DIR__ . '/../assets/imageArtits/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
    
                move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $filename);
                $picturePath = '/assets/imageArtits/' . $filename;
            }
    
            // ✅ Call model with picturePath
            echo json_encode($this->adminModel->addArtist($name, $style, $description, $origin, $picturePath));
    
        } catch (Exception $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
    }
    

    // Update an artist
    public function updateArtist() {
        try {
            // ✅ 1. Grab form fields
            $artistID = $_POST['artistID'];
            $name = $_POST['name'];
            $style = $_POST['style'];
            $description = $_POST['description'];
            $origin = $_POST['origin'];
    
            // ✅ 2. Set null picturePath (will stay null if no new upload)
            $picturePath = null;
    
            // ✅ 3. Check if a picture file was uploaded
            if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
                $filename = uniqid('artist_') . '.' . $ext;
    
                // ✅ Use your preferred path: imageArtits
                $uploadDir = __DIR__ . '/../assets/imageArtits/';
    
                // ✅ Create folder if it doesn't exist (good practice)
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
    
                // ✅ Move the uploaded file
                if (!move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $filename)) {
                    throw new Exception("Failed to move uploaded file.");
                }
    
                // ✅ Save relative path to DB
                $picturePath = '/assets/imageArtits/' . $filename;
            }
    
            // ✅ 4. Call your model function
            echo json_encode(
                $this->adminModel->updateArtist(
                    $artistID,
                    $name,
                    $style,
                    $description,
                    $origin,
                    $picturePath // can be null, your model handles it
                )
            );
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

//////////////////////////////////////////////////////////////////////////Order Management

public function getPaidOrders()
{
    try {
        $orders = $this->adminModel->getPaidOrders();
        echo json_encode(["success" => true, "data" => $orders]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

public function getOrderDetail()
{
    try {
        $orderID = $_GET['orderID'] ?? null;
        if (!$orderID) throw new Exception("Order ID is required");

        $data = $this->adminModel->getOrderDetails($orderID);
        echo json_encode(["success" => true, "data" => $data]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

//////////////////////////////////////////////////////////////////////////////////Restaurant

// AdminController.php

// GET
public function getRestaurants() {
    try {
        echo json_encode($this->adminModel->getAllRestaurants());
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// POST
public function createRestaurant() {
    try {
        // ✅ Validate required fields
        $requiredFields = ['name', 'address', 'cuisine', 'description', 'pricePerAdult', 'pricePerChild'];
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
                throw new Exception("Field '{$field}' is required.");
            }
        }

        // ✅ Get form data
        $name = $_POST['name'];
        $address = $_POST['address'];
        $cuisine = $_POST['cuisine'];
        $description = $_POST['description'];
        $pricePerAdult = is_numeric($_POST['pricePerAdult']) ? $_POST['pricePerAdult'] : 0;
        $pricePerChild = is_numeric($_POST['pricePerChild']) ? $_POST['pricePerChild'] : 0;

        $picturePath = null;
        $diningDetailPath = null;

        // ✅ Upload restaurantPicture
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('restaurant_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../assets/img/dining/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $filename);
            $picturePath = '/assets/img/dining/' . $filename;
        } else {
            throw new Exception("Main restaurant picture is required.");
        }

        // ✅ Upload diningDetailPicture (optional)
        if (isset($_FILES['diningPicture']) && $_FILES['diningPicture']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['diningPicture']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('dining_detail_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../assets/img/diningdetails/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            move_uploaded_file($_FILES['diningPicture']['tmp_name'], $uploadDir . $filename);
            $diningDetailPath = '/assets/img/diningdetails/' . $filename;
        }

        // ✅ Save to DB
        echo json_encode(
            $this->adminModel->createRestaurant(
                $name, $address, $cuisine, $description, $pricePerAdult, $pricePerChild, $picturePath, $diningDetailPath
            )
        );

    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}



// PUT
public function updateRestaurant() {
    try {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $cuisine = $_POST['cuisine'];
        $description = $_POST['description'];
        $pricePerAdult = $_POST['pricePerAdult'];
        $pricePerChild = $_POST['pricePerChild'];

        // ✅ Get current restaurant data
        $current = $this->adminModel->getRestaurantByID($id);
        if (!$current) throw new Exception("Restaurant not found!");

        // ✅ Default to old paths
        $picturePath = $current['restaurantPicture'];
        $diningDetailPath = $current['restaurantDiningDetailPicture'];

        // ✅ Only replace if new upload happened
        if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('restaurant_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../assets/img/dining/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            move_uploaded_file($_FILES['picture']['tmp_name'], $uploadDir . $filename);
            $picturePath = '/assets/img/dining/' . $filename;
        }

        if (isset($_FILES['diningPicture']) && $_FILES['diningPicture']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['diningPicture']['name'], PATHINFO_EXTENSION);
            $filename = uniqid('dining_detail_') . '.' . $ext;
            $uploadDir = __DIR__ . '/../assets/img/diningdetails/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            move_uploaded_file($_FILES['diningPicture']['tmp_name'], $uploadDir . $filename);
            $diningDetailPath = '/assets/img/diningdetails/' . $filename;
        }

        // ✅ Safe update, no path will be removed if not re-uploaded
        echo json_encode(
            $this->adminModel->updateRestaurant(
                $id, $name, $address, $cuisine, $description, $pricePerAdult, $pricePerChild, $picturePath, $diningDetailPath
            )
        );
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}



// DELETE
public function deleteRestaurant() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['restaurantID'])) {
            throw new Exception("Restaurant ID is required.");
        }

        echo json_encode($this->adminModel->deleteRestaurant($data['restaurantID']));
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

///////////////////////////////////////////////////////////////////////Restaurant Slot

public function getRestaurantSlots() {
    return $this->adminModel->getRestaurantSlots();
}

public function getAllDropDownRestaurants() {
    return $this->adminModel->getAllDropDownRestaurants();
}

public function addOrUpdateRestaurantSlot() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['slotID'])) {
            // ADD MODE: Require all fields
            if (!isset($data['restaurantID'], $data['startTime'], $data['endTime'], $data['capacity'])) {
                throw new Exception("Missing required fields");
            }

            echo json_encode($this->adminModel->addRestaurantSlot(
                $data['restaurantID'], $data['startTime'], $data['endTime'], $data['capacity']
            ));
        } else {
            // EDIT MODE: Only allow updating time + capacity
            if (!isset($data['slotID'], $data['startTime'], $data['endTime'], $data['capacity'])) {
                throw new Exception("Missing fields for update");
            }

            echo json_encode($this->adminModel->updateRestaurantSlot(
                $data['slotID'], $data['startTime'], $data['endTime'], $data['capacity']
            ));
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

public function deleteRestaurantSlot() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['slotID'])) throw new Exception("Slot ID required");
        echo json_encode($this->adminModel->deleteRestaurantSlot($data['slotID']));
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

//////////////////////////////////////////////////////////////Ticket Type

// GET all ticket types
public function getTicketTypes() {
    echo json_encode($this->adminModel->getTicketTypes());
}

// ADD or UPDATE ticket type
public function addOrUpdateTicketType() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['danceID'], $data['type'], $data['price'])) {
            throw new Exception("Missing required fields");
        }

        if (empty($data['ticketTypeID'])) {
            echo json_encode($this->adminModel->addTicketType($data['danceID'], $data['type'], $data['price']));
        } else {
            echo json_encode($this->adminModel->updateTicketType($data['ticketTypeID'], $data['danceID'], $data['type'], $data['price']));
        }
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// DELETE ticket type
public function deleteTicketType() {
    try {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['ticketTypeID'])) throw new Exception("TicketTypeID is required");
        echo json_encode($this->adminModel->deleteTicketType($data['ticketTypeID']));
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => $e->getMessage()]);
    }
}

// GET all dances
public function getDances() {
    echo json_encode($this->adminModel->getDances());
}
}
?>
