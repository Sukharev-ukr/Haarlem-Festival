<?php
require_once(__DIR__ . "/BaseModel.php");

class AdminModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }    

    // Fetch all users with search, sort, and registered_day
public function getUsers($search = "", $sortColumn = "userID", $sortOrder = "ASC") {
    try {
        // Whitelist sort columns to prevent SQL Injection
        $allowedSortColumns = ['userID', 'userName', 'Email', 'role', 'registered_day'];
        if (!in_array($sortColumn, $allowedSortColumns)) {
            $sortColumn = 'userID';
        }
        
        $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC'; // only allow ASC or DESC
        
        $sql = "SELECT userID, userName, Email, role, registered_day 
                FROM User 
                WHERE userName LIKE ? OR Email LIKE ? OR role LIKE ?
                ORDER BY $sortColumn $sortOrder";
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(["%$search%", "%$search%", "%$search%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}

// Add new user
public function addUser($userName, $email, $password, $role) {
    try {
        if (!in_array($role, ['Admin', 'Employee'])) {
            throw new Exception("Invalid role value.");
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO User (userName, Email, password, role, registered_day) VALUES (?, ?, ?, ?, NOW())";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$userName, $email, $hashedPassword, $role]);

        return ["success" => true, "message" => "User added successfully."];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error adding user: " . $e->getMessage()];
    }
}

// Update user
public function updateUser($userID, $userName, $email, $role) {
    try {
        if (!in_array($role, ['Admin', 'Employee'])) {
            throw new Exception("Invalid role value.");
        }

        $sql = "UPDATE User SET userName = ?, Email = ?, role = ? WHERE userID = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$userName, $email, $role, $userID]);

        return ["success" => true, "message" => "User updated successfully."];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error updating user: " . $e->getMessage()];
    }
}

// Delete user
public function deleteUser($userID) {
    try {
        $sql = "DELETE FROM User WHERE userID = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$userID]);
        return ["success" => true, "message" => "User deleted successfully."];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error deleting user: " . $e->getMessage()];
    }
}

    ///////////////////////////////////////////////////////////////Dance
// Fetch only Dance events
public function getDanceEvents() {
    try {
        $sql = "SELECT danceID, location, startTime, endTime, day, danceDate, danceCapacity FROM Dance";
        $stmt = self::$pdo->query($sql);
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $events; // ✅ Return only the array, no extra JSON structure
    } catch (Exception $e) {
        return []; // Return empty array if there's an error
    }
}

public function createDanceEvent($location, $startTime, $endTime, $day, $danceDate, $danceCapacity, $duration) {
    try {
        // Convert duration to HH:MM:SS format
        $formattedDuration = gmdate("H:i:s", strtotime($duration));

        $sql = "INSERT INTO Dance (location, startTime, endTime, day, danceDate, danceCapacity, duration) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = self::$pdo->prepare($sql);
        $success = $stmt->execute([$location, $startTime, $endTime, $day, $danceDate, $danceCapacity, $formattedDuration]);

        if ($success) {
            return ["success" => true, "message" => "Dance event created successfully."];
        } else {
            throw new Exception("Failed to create dance event.");
        }
    } catch (Exception $e) {
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

public function updateDanceEvent($danceID, $location, $startTime, $endTime, $day,  $danceCapacity, $danceDate) {
    try {
        $sql = "UPDATE Dance SET location = ?, startTime = ?, endTime = ?, day = ?, danceDate = ?, danceCapacity = ? WHERE danceID = ?";
        
        $stmt = self::$pdo->prepare($sql);
        $success = $stmt->execute([$location, $startTime, $endTime, $day, $danceDate, $danceCapacity, $danceID]);

        if ($success) {
            return ["success" => true, "message" => "Dance event updated successfully."];
        } else {
            throw new Exception("Failed to update dance event.");
        }
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}


public function deleteDanceEvent($danceID) {
    $sql = "DELETE FROM Dance WHERE danceID = ?";
    
    $stmt = self::$pdo->prepare($sql);
    return $stmt->execute([$danceID]);
}

///////////////////////////////////////////////////////////////////////////////Artistttttttttttttttttttttttttt
public function getArtists() {
    try {
        $sql = "SELECT artistID, name, style, description, origin, picture FROM Artist";
        $stmt = self::$pdo->query($sql);
        $artists = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!$artists) {
            return ["success" => false, "message" => "No artists found."];
        }

        return ["success" => true, "data" => $artists]; // ✅ Proper JSON format
    } catch (Exception $e) {
        error_log("Error fetching artists: " . $e->getMessage()); // Log error
        return ["success" => false, "message" => "Database error: " . $e->getMessage()];
    }
}

// Add a new artist
public function addArtist($name, $style, $description, $origin, $picturePath = null) {
    try {
        $sql = "INSERT INTO Artist (name, style, description, origin, picture) VALUES (?, ?, ?, ?, ?)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$name, $style, $description, $origin, $picturePath]);

        return ["success" => true, "message" => "Artist added successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error adding artist: " . $e->getMessage()];
    }
}


// Update an artist
public function updateArtist($artistID, $name, $style, $description, $origin, $picturePath = null) {
    try {
        if ($picturePath) {
            $sql = "UPDATE Artist SET name = ?, style = ?, description = ?, origin = ?, picture = ? WHERE artistID = ?";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$name, $style, $description, $origin, $picturePath, $artistID]);
        } else {
            // If no new picture, don't touch old picture
            $sql = "UPDATE Artist SET name = ?, style = ?, description = ?, origin = ? WHERE artistID = ?";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$name, $style, $description, $origin, $artistID]);
        }

        return ["success" => true, "message" => "Artist updated successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error updating artist: " . $e->getMessage()];
    }
}


// Delete an artist
public function deleteArtist($artistID) {
    try {
        $sql = "DELETE FROM Artist WHERE artistID = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$artistID]);

        return ["success" => true, "message" => "Artist deleted successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error deleting artist: " . $e->getMessage()];
    }
}

////////////////////////////////////////////////////////////////////////Dance-Artist
    // Get all Dance-Artist Assignments
    public function getDanceArtistAssignments() {
        try {
            $sql = "SELECT DA.danceID, D.location, DA.artistID, A.name, D.startTime, D.endTime, D.danceDate, D.day 
                    FROM DanceArtist DA
                    JOIN Dance D ON DA.danceID = D.danceID
                    JOIN Artist A ON DA.artistID = A.artistID";
            $stmt = self::$pdo->query($sql);
            $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return ["success" => true, "data" => $assignments];
        } catch (Exception $e) {
            return ["success" => false, "message" => "Error fetching assignments: " . $e->getMessage()];
        }
    }

    // Assign a Dance to an Artist
    public function assignArtistToDance($danceID, $artistID) {
        try {
            $sql = "INSERT INTO DanceArtist (danceID, artistID) VALUES (?, ?)";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$danceID, $artistID]);

            return ["success" => true, "message" => "Artist assigned successfully"];
        } catch (Exception $e) {
            return ["success" => false, "message" => "Error assigning artist: " . $e->getMessage()];
        }
    }

    // Update an existing assignment
    public function updateDanceArtistAssignment($danceID, $artistID, $newDanceID, $newArtistID) {
        try {
            $sql = "UPDATE DanceArtist SET danceID = ?, artistID = ? WHERE danceID = ? AND artistID = ?";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$newDanceID, $newArtistID, $danceID, $artistID]);

            return ["success" => true, "message" => "Assignment updated successfully"];
        } catch (Exception $e) {
            return ["success" => false, "message" => "Error updating assignment: " . $e->getMessage()];
        }
    }

    // Delete an assignment
    public function deleteDanceArtistAssignment($danceID, $artistID) {
        try {
            $sql = "DELETE FROM DanceArtist WHERE danceID = ? AND artistID = ?";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$danceID, $artistID]);

            return ["success" => true, "message" => "Assignment deleted successfully"];
        } catch (Exception $e) {
            return ["success" => false, "message" => "Error deleting assignment: " . $e->getMessage()];
        }
    }

    //for the drop down list of dance base on picking date
    public function fetchDanceLocationsByDate($date) {
        try {
            $sql = "SELECT danceID, location FROM Dance WHERE danceDate = ?";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return [];
        }
    }

//////////////////////////////////////////////////////////////////////////Order Management

    // Get Paid Orders (summary)
public function getPaidOrders()
{
    $sql = "
        SELECT 
            O.orderID, O.userID, U.userName, O.orderDate, O.total, O.status
        FROM `Order` O
        INNER JOIN User U ON U.userID = O.userID
        WHERE O.status = 'paid'
        ORDER BY O.orderDate DESC;
    ";
    $stmt = self::$pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get Order Details
public function getOrderDetails($orderID)
{
    $sql = "
        SELECT 
            O.orderID, O.userID, U.userName, O.orderDate, O.total, O.status,
            OI.orderItemID, OI.price AS itemPrice, OI.bookingType,
            D.location AS danceLocation, D.day AS danceDay, D.danceDate, 
            COALESCE(GROUP_CONCAT(DISTINCT A.name ORDER BY A.name ASC SEPARATOR ', '), '') AS artistName,
            HTR.numParticipants, HTS.startTime AS tourStartTime,
            R.amountAdults, R.amountChildren, Rest.restaurantName
        FROM `Order` O
        INNER JOIN User U ON U.userID = O.userID
        INNER JOIN OrderItem OI ON OI.orderID = O.orderID
        LEFT JOIN DanceTicketOrder DTO ON DTO.orderItemID = OI.orderItemID
        LEFT JOIN DanceTicket DT ON DT.danceTicketID = DTO.danceTicketOrderID
        LEFT JOIN TicketType TT ON TT.ticketTypeID = DT.ticketTypeID
        LEFT JOIN Dance D ON D.danceID = TT.danceID
        LEFT JOIN DanceArtist DA ON DA.danceID = D.danceID
        LEFT JOIN Artist A ON A.artistID = DA.artistID
        LEFT JOIN HistoryTourReservation HTR ON HTR.orderItemID = OI.orderItemID
        LEFT JOIN HistoryTourSession HTS ON HTS.sessionID = HTR.sessionID
        LEFT JOIN Reservation R ON R.orderItemID = OI.orderItemID
        LEFT JOIN Restaurant Rest ON Rest.restaurantID = R.restaurantID
        WHERE O.orderID = ?
        GROUP BY OI.orderItemID
    ";

    $stmt = self::$pdo->prepare($sql);
    $stmt->execute([$orderID]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
///////////////////////////////////////////////////////////////////////Restaurant

// Get All Restaurants
public function getAllRestaurants() {
    try {
        $sql = "SELECT restaurantID, restaurantName, address, cuisine, description, pricePerAdult, pricePerChild, restaurantPicture, restaurantDiningDetailPicture FROM Restaurant";
        $stmt = self::$pdo->query($sql);
        return ["success" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

// Create Restaurant
public function createRestaurant($name, $address, $cuisine, $description, $pricePerAdult, $pricePerChild, $picture, $diningPicture) {
    try {
        $sql = "INSERT INTO Restaurant (restaurantName, address, cuisine, description, pricePerAdult, pricePerChild, restaurantPicture, restaurantDiningDetailPicture) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$name, $address, $cuisine, $description, $pricePerAdult, $pricePerChild, $picture, $diningPicture]);
        return ["success" => true, "message" => "Restaurant created successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

// Update Restaurant
public function updateRestaurant($id, $name, $address, $cuisine, $description, $pricePerAdult, $pricePerChild, $picture, $diningPicture) {
    try {
        $sql = "UPDATE Restaurant SET restaurantName=?, address=?, cuisine=?, description=?, pricePerAdult=?, pricePerChild=?, restaurantPicture=?, restaurantDiningDetailPicture=? WHERE restaurantID=?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$name, $address, $cuisine, $description, $pricePerAdult, $pricePerChild, $picture, $diningPicture, $id]);
        return ["success" => true, "message" => "Restaurant updated successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

// Delete Restaurant
public function deleteRestaurant($id) {
    try {
        $sql = "DELETE FROM Restaurant WHERE restaurantID = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$id]);
        return ["success" => true, "message" => "Restaurant deleted successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

public function getRestaurantByID($id) {
    try {
        $sql = "SELECT * FROM Restaurant WHERE restaurantID = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return false; // You could also throw exception if you want
    }
}

///////////////////////////////////////////////////////////////////Restaurant Slot
// Get all Restaurant Slots with Restaurant Name
public function getRestaurantSlots() {
    try {
        $sql = "SELECT RS.slotID, RS.restaurantID, R.restaurantName, RS.startTime, RS.endTime, RS.capacity 
                FROM RestaurantSlot RS
                INNER JOIN Restaurant R ON RS.restaurantID = R.restaurantID";
        $stmt = self::$pdo->query($sql);
        return ["success" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

public function getAllRestaurantsSimple() {
    try {
        $stmt = self::$pdo->query("SELECT restaurantID, restaurantName FROM Restaurant");
        return ["success" => true, "data" => $stmt->fetchAll(PDO::FETCH_ASSOC)];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

// Create
public function createRestaurantSlot($restaurantID, $startTime, $endTime, $capacity) {
    try {
        $sql = "INSERT INTO RestaurantSlot (restaurantID, startTime, endTime, capacity) VALUES (?, ?, ?, ?)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$restaurantID, $startTime, $endTime, $capacity]);
        return ["success" => true];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

// Update
public function updateRestaurantSlot($slotID, $startTime, $endTime, $capacity) {
    try {
        $sql = "UPDATE RestaurantSlot SET startTime=?, endTime=?, capacity=? WHERE slotID=?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$startTime, $endTime, $capacity, $slotID]);
        return ["success" => true, "message" => "Slot updated successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}

// Delete
public function deleteRestaurantSlot($slotID) {
    try {
        $sql = "DELETE FROM RestaurantSlot WHERE slotID=?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$slotID]);
        return ["success" => true];
    } catch (Exception $e) {
        return ["success" => false, "message" => $e->getMessage()];
    }
}


}
?>
