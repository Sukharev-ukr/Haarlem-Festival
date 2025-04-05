<?php
require_once(__DIR__ . "../../models/BaseModel.php");

class CartModel extends BaseModel {
    public function __construct() {
        parent::__construct();
    }

    public function addTicketsToCart($userId, $danceID, $tickets) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("SELECT orderID FROM `Order` WHERE userID = ? AND status = 'unpaid' LIMIT 1");
            $stmt->execute([$userId]);
            $orderId = $stmt->fetchColumn();

            if (!$orderId) {
                $stmt = $this->db->prepare("INSERT INTO `Order` (userID, orderDate, status, total) VALUES (?, NOW(), 'unpaid', 0)");
                $stmt->execute([$userId]);
                $orderId = $this->db->lastInsertId();
            }

            foreach ($tickets as $ticket) {
                $ticketTypeId = $ticket['ticketTypeId'];
                $quantity = (int)$ticket['quantity'];
                $price = (float)$ticket['price'];
                $totalPrice = $price * $quantity;

                if ($quantity <= 0 || $price < 0) {
                    throw new Exception("Invalid quantity or price for ticketTypeId: $ticketTypeId");
                }

                $stmt = $this->db->prepare("INSERT INTO OrderItem (orderID, price, bookingType) VALUES (?, ?, 'Dance')");
                $stmt->execute([$orderId, $totalPrice]);
                $orderItemId = $this->db->lastInsertId();

                $stmt = $this->db->prepare("INSERT INTO DanceTicketOrder (orderItemID, ticketQuantity, totalPrice) VALUES (?, ?, ?)");
                $stmt->execute([$orderItemId, $quantity, $totalPrice]);
                $danceTicketOrderId = $this->db->lastInsertId();

                $stmt = $this->db->prepare("INSERT INTO DanceTicket (danceTicketOrderID, ticketTypeID) VALUES (?, ?)");
                for ($i = 0; $i < $quantity; $i++) {
                    $stmt->execute([$danceTicketOrderId, $ticketTypeId]);
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("❌ Error in addTicketsToCart: " . $e->getMessage());
            return false;
        }
    }

    private function getRestaurantPrices($restaurantID) {
        $stmt = $this->db->prepare("SELECT pricePerAdult, pricePerChild FROM Restaurant WHERE restaurantID = ?");
        $stmt->execute([$restaurantID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addReservationToCart($userID, $reservationData, $pricing) {
        $stmt = $this->db->prepare("SELECT orderID FROM `Order` WHERE userID = ? AND status = 'unpaid' LIMIT 1");
        $stmt->execute([$userID]);
        $orderID = $stmt->fetchColumn();

        if (!$orderID) {
            $stmt = $this->db->prepare("INSERT INTO `Order` (userID, orderDate, status, total) VALUES (?, NOW(), 'unpaid', 0)");
            $stmt->execute([$userID]);
            $orderID = $this->db->lastInsertId();
        }

        $stmt = $this->db->prepare("INSERT INTO `OrderItem` (orderID, price, bookingType) VALUES (?, ?, 'Restaurant')");
        $stmt->execute([$orderID, $pricing['totalCost']]);
        $orderItemID = $this->db->lastInsertId();

        $stmt = $this->db->prepare("INSERT INTO Reservation (
            orderItemID, restaurantID, reservationDate, specialRequests,
            amountAdults, amountChildren, reservationFee
        ) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $orderItemID,
            $reservationData['restaurantID'],
            $reservationData['reservationDate'],
            $reservationData['specialRequests'],
            $reservationData['adults'],
            $reservationData['children'],
            $pricing['reservationFee']
        ]);

        $reservationID = $this->db->lastInsertId();
        $stmt = $this->db->prepare("INSERT INTO ReservationSlot (slotID, reservationID) VALUES (?, ?)");
        $stmt->execute([$reservationData['slotID'], $reservationID]);

        return true;
    }

    public function getCartItems($userId) {
        $sql = "
                SELECT 
                    O.orderID, O.orderDate, O.total, O.status, OI.orderItemID, OI.price AS itemPrice, OI.bookingType,

                    -- Dance Tickets
                    GROUP_CONCAT(DISTINCT A.name ORDER BY A.name ASC SEPARATOR ', ') AS artistName,
                    D.location, D.startTime, D.endTime, D.day, D.danceDate,
                    TT.type AS ticketType, TT.price AS ticketPrice, DTO.ticketQuantity,

                    -- History Tours
                    HTR.reservationID, HTS.startTime AS tourStartTime, HTR.numParticipants, HTR.price AS tourPrice,

                    -- Restaurant Reservations
                    R.reservationID AS restReservationID, R.restaurantID, R.amountAdults, R.amountChildren, R.reservationFee, R.reservationDate,
                    Rest.restaurantName AS restaurantName, Rest.address AS restaurantLocation, R.specialRequests

                FROM `Order` O
                INNER JOIN OrderItem OI ON O.orderID = OI.orderID

                -- Dance Ticket Joins
                LEFT JOIN DanceTicketOrder DTO ON DTO.orderItemID = OI.orderItemID
                LEFT JOIN DanceTicket DT ON DT.danceTicketID = DTO.danceTicketOrderID
                LEFT JOIN TicketType TT ON TT.ticketTypeID = DT.ticketTypeID
                LEFT JOIN Dance D ON D.danceID = TT.danceID
                LEFT JOIN DanceArtist DA ON DA.danceID = D.danceID
                LEFT JOIN Artist A ON A.artistID = DA.artistID

                -- History Tour Joins
                LEFT JOIN HistoryTourReservation HTR ON HTR.orderItemID = OI.orderItemID
                LEFT JOIN HistoryTourSession HTS ON HTS.sessionID = HTR.sessionID

                -- Restaurant Reservation Joins
                LEFT JOIN Reservation R ON R.orderItemID = OI.orderItemID
                LEFT JOIN Restaurant Rest ON Rest.restaurantID = R.restaurantID

                WHERE O.userID = ? AND O.status = 'unpaid'
                GROUP BY O.orderID, OI.orderItemID, D.danceID, TT.ticketTypeID, DTO.ticketQuantity, HTR.reservationID, R.reservationID;
            ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartItemsByOrderID($orderId) {
        $sql = "
            SELECT 
                O.orderID, O.orderDate, O.total, O.status, OI.orderItemID, OI.price AS itemPrice, OI.bookingType,
    
                -- Dance Tickets
                GROUP_CONCAT(DISTINCT A.name ORDER BY A.name ASC SEPARATOR ', ') AS artistName,
                D.location, D.startTime, D.endTime, D.day, D.danceDate,
                TT.type AS ticketType, TT.price AS ticketPrice, DTO.ticketQuantity,
    
                -- History Tours
                HTR.reservationID, HTS.startTime AS tourStartTime, HTR.numParticipants, HTR.price AS tourPrice,
    
                -- Restaurant Reservations
                R.reservationID AS restReservationID, R.restaurantID, R.amountAdults, R.amountChildren, R.reservationFee, R.reservationDate,
                Rest.restaurantName AS restaurantName, Rest.address AS restaurantLocation, R.specialRequests
    
            FROM `Order` O
            INNER JOIN OrderItem OI ON O.orderID = OI.orderID
    
            -- Dance Ticket Joins
            LEFT JOIN DanceTicketOrder DTO ON DTO.orderItemID = OI.orderItemID
            LEFT JOIN DanceTicket DT ON DT.danceTicketID = DTO.danceTicketOrderID
            LEFT JOIN TicketType TT ON TT.ticketTypeID = DT.ticketTypeID
            LEFT JOIN Dance D ON D.danceID = TT.danceID
            LEFT JOIN DanceArtist DA ON DA.danceID = D.danceID
            LEFT JOIN Artist A ON A.artistID = DA.artistID
    
            -- History Tour Joins
            LEFT JOIN HistoryTourReservation HTR ON HTR.orderItemID = OI.orderItemID
            LEFT JOIN HistoryTourSession HTS ON HTS.sessionID = HTR.sessionID
    
            -- Restaurant Reservation Joins
            LEFT JOIN Reservation R ON R.orderItemID = OI.orderItemID
            LEFT JOIN Restaurant Rest ON Rest.restaurantID = R.restaurantID
    
            WHERE O.orderID = ?
            GROUP BY O.orderID, OI.orderItemID, D.danceID, TT.ticketTypeID, DTO.ticketQuantity, HTR.reservationID, R.reservationID;
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function removeOrderItem($orderItemId) {
        $stmt = $this->db->prepare("DELETE FROM OrderItem WHERE orderItemID = ?");
        return $stmt->execute([$orderItemId]);
    }

    public function updateOrderTotal($orderId) {
        $query = "SELECT SUM(price) AS total FROM OrderItem WHERE orderID = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $row = $stmt->fetch();
        $total = $row['total'] ?? 0;

        $update = "UPDATE `Order` SET total = ? WHERE orderID = ?";
        $stmt = $this->db->prepare($update);
        $stmt->execute([$total, $orderId]);

        return $total;
    }

    public function getOrderById($orderId) {
        $stmt = $this->db->prepare("SELECT orderID, userID, orderDate, status, total FROM `Order` WHERE orderID = ? LIMIT 1");
        $stmt->execute([$orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("SELECT orderItemID, orderID, price, bookingType FROM OrderItem WHERE orderID = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}