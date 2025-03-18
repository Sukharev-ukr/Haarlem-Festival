<?php
 require_once(__DIR__. ("../../models/BaseModel.php"));

 class CartModel extends BaseModel {

      public function __construct() {
          parent::__construct();
      }    
      
      public function addTicketsToCart($userId, $danceID, $tickets) {
        // Get or create unpaid order
        $stmt = self::$pdo->prepare("SELECT orderID FROM `Order` WHERE userID = ? AND status = 'unpaid' LIMIT 1");
        $stmt->execute([$userId]);
        $orderId = $stmt->fetchColumn();

        if (!$orderId) {
            $stmt = self::$pdo->prepare("INSERT INTO `Order` (userID, orderDate, status, total) VALUES (?, NOW(), 'unpaid', 0)");
            $stmt->execute([$userId]);
            $orderId = self::$pdo->lastInsertId();
        }

        foreach ($tickets as $ticket) {
            $ticketTypeId = $ticket['ticketTypeId'];
            $quantity = $ticket['quantity'];
            $price = $ticket['price'];
            $totalPrice = $price * $quantity;

            // Insert into OrderItem
            $stmt = self::$pdo->prepare("INSERT INTO `OrderItem` (orderID, price, BookingType) VALUES (?, ?, 'DanceTicket')");
            $stmt->execute([$orderId, $totalPrice]);
            $orderItemId = self::$pdo->lastInsertId();

            // Insert into DanceTicketOrder
            $stmt = self::$pdo->prepare("INSERT INTO `DanceTicketOrder` (danceTicketId, OrderItemId, TicketQuantity, TotalPrice) VALUES (?, ?, ?, ?)");
            $stmt->execute([$ticketTypeId, $orderItemId, $quantity, $totalPrice]);
        }

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
                R.reservationID AS restReservationID, R.restaurantID, R.amountAdults, R.amountChildren, R.reservationFee,
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