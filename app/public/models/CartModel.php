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

    
 }