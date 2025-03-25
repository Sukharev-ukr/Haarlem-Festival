<?php
 require_once(__DIR__. ("../../models/BaseModel.php"));

 class CartModel extends BaseModel {

      public function __construct() {
          parent::__construct();
      }    
      
      public function addTicketsToCart($userId, $danceID, $tickets)
{
    try {
        // Begin transaction to ensure rollback on failure
        self::$pdo->beginTransaction();

        // heck if there's already an unpaid order for the user
        $stmt = self::$pdo->prepare("SELECT orderID FROM `Order` WHERE userID = ? AND status = 'unpaid' LIMIT 1");
        $stmt->execute([$userId]);
        $orderId = $stmt->fetchColumn();

        //If not, create a new unpaid order
        if (!$orderId) {
            $stmt = self::$pdo->prepare("INSERT INTO `Order` (userID, orderDate, status, total) VALUES (?, NOW(), 'unpaid', 0)");
            $stmt->execute([$userId]);
            $orderId = self::$pdo->lastInsertId();
        }

        //Loop through selected ticket types
        foreach ($tickets as $ticket) {
            $ticketTypeId = $ticket['ticketTypeId'];
            $quantity     = (int)$ticket['quantity'];
            $price        = (float)$ticket['price'];
            $totalPrice   = $price * $quantity;

            // Check valid quantity and price
            if ($quantity <= 0 || $price < 0) {
                throw new Exception("Invalid quantity or price for ticketTypeId: $ticketTypeId");
            }

            //Insert into OrderItem
            $stmt = self::$pdo->prepare("INSERT INTO OrderItem (orderID, price, bookingType) VALUES (?, ?, 'Dance')");
            $stmt->execute([$orderId, $totalPrice]);
            $orderItemId = self::$pdo->lastInsertId();

            //Insert into DanceTicketOrder
            $stmt = self::$pdo->prepare("INSERT INTO DanceTicketOrder (orderItemID, ticketQuantity, totalPrice) VALUES (?, ?, ?)");
            $stmt->execute([$orderItemId, $quantity, $totalPrice]);
            $danceTicketOrderId = self::$pdo->lastInsertId();

            // Insert into DanceTicket for each ticket (1 row per physical ticket)
            $stmt = self::$pdo->prepare("INSERT INTO DanceTicket (danceTicketOrderID, ticketTypeID) VALUES (?, ?)");
            for ($i = 0; $i < $quantity; $i++) {
                $stmt->execute([$danceTicketOrderId, $ticketTypeId]);
            }
        }

        // All queries successful, commit the transaction
        self::$pdo->commit();
        return true;
    } catch (Exception $e) {
        //Something went wrong, rollback any DB changes
        self::$pdo->rollBack();

        // Optional: Log the error for debugging
        error_log("❌ Error in addTicketsToCart: " . $e->getMessage());

        return false; // Return failure to controller
    }
}


    private function getRestaurantPrices($restaurantID) {
        $stmt = self::$pdo->prepare("SELECT pricePerAdult, pricePerChild FROM Restaurant WHERE restaurantID = ?");
        $stmt->execute([$restaurantID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function addReservationToCart($userID, $reservationData, $pricing) {
        // 1. Check or create unpaid order
        $stmt = self::$pdo->prepare("SELECT orderID FROM `Order` WHERE userID = ? AND status = 'unpaid' LIMIT 1");
        $stmt->execute([$userID]);
        $orderID = $stmt->fetchColumn();
    
        if (!$orderID) {
            $stmt = self::$pdo->prepare("INSERT INTO `Order` (userID, orderDate, status, total) VALUES (?, NOW(), 'unpaid', 0)");
            $stmt->execute([$userID]);
            $orderID = self::$pdo->lastInsertId();
        }
    
        // 2. Insert into OrderItem
        $stmt = self::$pdo->prepare("INSERT INTO `OrderItem` (orderID, price, bookingType) VALUES (?, ?, 'Restaurant')");
        $stmt->execute([$orderID, $pricing['totalCost']]);
        $orderItemID = self::$pdo->lastInsertId();
    
        // 3. Insert into Reservation
        $stmt = self::$pdo->prepare("
            INSERT INTO Reservation (
                orderItemID, restaurantID, reservationDate, specialRequests,
                amountAdults, amountChildren, reservationFee
            ) VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $orderItemID,
            $reservationData['restaurantID'],
            $reservationData['reservationDate'],
            $reservationData['specialRequests'],
            $reservationData['adults'],
            $reservationData['children'],
            $pricing['reservationFee']
        ]);
    
        // 4. Link slot to reservation
        $reservationID = self::$pdo->lastInsertId();
        $stmt = self::$pdo->prepare("INSERT INTO ReservationSlot (slotID, reservationID) VALUES (?, ?)");
        $stmt->execute([$reservationData['slotID'], $reservationID]);
    
        return true;
    }
    

    //Using at ShoppingCart to retreive all of order in cart
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
                Rest.restaurantName AS restaurantName, Rest.address AS restaurantLocation
    
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
    
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    //Using at ShoppingCart to remove the order that customer does not want to pay.
    public function removeOrderItem($orderItemId) {
        $sql = "DELETE FROM OrderItem WHERE orderItemID = ?";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([$orderItemId]);
    }

    
 }