<?php
require_once(__DIR__ . "/BaseModel.php");

class AdminModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }    

    // Fetch all users with sorting, filtering, and search
    public function getUsers($search = "", $sortColumn = "userID", $sortOrder = "ASC") {
        $sql = "SELECT userName, Email, role 
                FROM User 
                WHERE userName LIKE ? OR Email LIKE ? OR role LIKE ?
                ORDER BY $sortColumn $sortOrder";
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute(["%$search%", "%$search%", "%$search%"]); // Now correctly binds three values
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } 

    // Add new user
    public function addUser($userName, $email, $password, $role) {
        try {
            // Hash the password securely
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO User (userName, Email, password, role, registration_date) VALUES (?, ?, ?, ?, NOW())";
            $stmt = self::$pdo->prepare($sql);
            $stmt->execute([$userName, $email, $hashedPassword, $role]);

            return ["success" => true, "message" => "User added successfully"];
        } catch (Exception $e) {
            return ["success" => false, "message" => "Error adding user: " . $e->getMessage()];
        }
    }

    // Update user details
    public function updateUser($userID, $userName, $email, $role) {
        $sql = "UPDATE User SET userName = ?, Email = ?, role = ? WHERE userID = ?";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([$userName, $email, $role, $userID]);
    }

    // Delete user
    public function deleteUser($userID) {
        $sql = "DELETE FROM User WHERE userID = ?";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([$userID]);
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
        $sql = "SELECT artistID, name, style, description, origin FROM Artist";
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
public function addArtist($name, $style, $description, $origin) {
    try {
        $sql = "INSERT INTO Artist (name, style, description, origin) VALUES (?, ?, ?, ?)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$name, $style, $description, $origin]);

        return ["success" => true, "message" => "Artist added successfully"];
    } catch (Exception $e) {
        return ["success" => false, "message" => "Error adding artist: " . $e->getMessage()];
    }
}

// Update an artist
public function updateArtist($artistID, $name, $style, $description, $origin) {
    try {
        $sql = "UPDATE Artist SET name = ?, style = ?, description = ?, origin = ? WHERE artistID = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$name, $style, $description, $origin, $artistID]);

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
}
?>
