<?php
   require_once(__DIR__ . "/BaseModel.php");

   class EmployeeModel extends BaseModel {
       
       public function __construct() {
        parent:: __construct();
       }
       
       public function getTicketByQRCode($ticketID) {
        $stmt = self::$pdo->prepare("SELECT * FROM DanceTicketOrder WHERE DanceTicketOrderID = ?");
        $stmt->execute([$ticketID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function markTicketAsUsed($ticketID) {
        $stmt = self::$pdo->prepare("UPDATE DanceTicketOrder SET status = 'used' WHERE DanceTicketOrderID = ?");
        return $stmt->execute([$ticketID]);
    }

 }