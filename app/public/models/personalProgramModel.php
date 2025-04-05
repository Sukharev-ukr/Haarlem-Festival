<?php
// models/PersonalProgramModel.php

require_once __DIR__ . '/BaseModel.php';

class PersonalProgramModel extends BaseModel
{
    public function getProgramItemsByUser($userID)
    {
        $sql = "
            SELECT 
                ppi.programItemID,
                pp.programName,
                ppi.itemType,
                ppi.sessionTime,

                -- Restaurant reservation
                r.reservationID,
                r.reservationDate,
                r.amountAdults,
                r.amountChildren,
                r.specialRequests,
                r.reservationFee,
                rs.startTime AS restaurantStartTime,
                rs.endTime AS restaurantEndTime,
                rest.restaurantName,
                rest.address AS restaurantAddress,

                -- Order & Price Info
                oi.price AS basePrice,
                o.status AS orderStatus,
                o.total AS totalOrderPrice,

                -- Dance info
                d.danceID,
                d.location AS danceLocation,
                d.startTime AS danceStart,
                d.endTime AS danceEnd,
                d.danceDate,

                -- History tour info
                hts.startTime AS historyStartTime,
                hts.language AS historyLanguage,
                ht.historyLocation

            FROM PersonalProgramItem ppi
            INNER JOIN PersonalProgram pp ON pp.programID = ppi.programID

            -- Restaurant join
            LEFT JOIN Reservation r ON r.reservationID = ppi.reservationID
            LEFT JOIN ReservationSlot rslot ON rslot.reservationID = r.reservationID
            LEFT JOIN RestaurantSlot rs ON rs.slotID = rslot.slotID
            LEFT JOIN Restaurant rest ON rest.restaurantID = r.restaurantID

            -- Link to order
            LEFT JOIN OrderItem oi ON oi.orderItemID = r.orderItemID
            LEFT JOIN `Order` o ON o.orderID = oi.orderID

            -- Dance join
            LEFT JOIN DanceTicketOrder dto ON dto.orderItemID = ppi.orderItemID
            LEFT JOIN DanceTicket dt ON dt.danceTicketOrderID = dto.DanceTicketOrderID
            LEFT JOIN TicketType tt ON tt.ticketTypeID = dt.ticketTypeID
            LEFT JOIN Dance d ON d.danceID = tt.danceID

            -- History tour join
            LEFT JOIN HistoryTourReservation htr ON htr.reservationID = ppi.reservationID
            LEFT JOIN HistoryTourSession hts ON hts.sessionID = htr.sessionID
            LEFT JOIN HistoryTour ht ON ht.historyTourID = hts.historyTourID

            WHERE pp.userID = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }      

    // Create a new personal program for a user
    public function createPersonalProgram($userID, $programName) {
        $sql = "INSERT INTO PersonalProgram (userID, programName) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userID, $programName]);
        
        return $this->db->lastInsertId(); // Return the programID of the newly created personal program
    }
    public function createPersonalProgramItem($programID, $orderItem, $itemType) {
        // Ensure sessionTime is valid
        $validSessionTimes = ['Morning', 'Afternoon', 'Evening'];
        $sessionTime = isset($orderItem['sessionTime']) && in_array($orderItem['sessionTime'], $validSessionTimes) 
                        ? $orderItem['sessionTime'] 
                        : null; // or 'Morning' as a default if applicable
    
        $sql = "INSERT INTO PersonalProgramItem (programID, orderItemID, itemType, sessionTime) 
                VALUES (?, ?, ?, ?)";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $programID,               // Personal program reference
            $orderItem['orderItemID'], // The unique order item ID
            $itemType,                // The type of item (Restaurant, Dance, History)
            $sessionTime              // The session time for the item
        ]);
    }
    
    
    

    public function showPersonalProgram() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $userID = $_SESSION['user']['userID'] ?? null;
        
        if (!$userID) {
            header("Location: /user/login");
            exit;
        }
    
        // Fetch program items for the logged-in user
        $programItems = $this->getProgramItemsByUser($userID);
    
        // Pass the data to the view
        require_once __DIR__ . '/../views/pages/personal-program.php';
    }
    
}
