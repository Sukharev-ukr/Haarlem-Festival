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
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO User (userName, Email, password, role, registration_date) VALUES (?, ?, ?, ?, NOW())";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([$userName, $email, $hashedPassword, $role]);
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


    
}
?>
