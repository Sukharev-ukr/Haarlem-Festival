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

    public function getDanceTickets($username = null) {
        $sql = "SELECT 
                    U.userName,
                    D.location,
                    TT.type AS ticketType,
                    TT.price,
                    DT.status,
                    DT.danceTicketID
                FROM DanceTicket DT
                INNER JOIN DanceTicketOrder DTO ON DT.danceTicketOrderID = DTO.danceTicketOrderID
                INNER JOIN OrderItem OI ON DTO.orderItemID = OI.orderItemID
                INNER JOIN `Order` O ON OI.orderID = O.orderID
                INNER JOIN `User` U ON O.userID = U.userID
                INNER JOIN TicketType TT ON DT.ticketTypeID = TT.ticketTypeID
                INNER JOIN Dance D ON TT.danceID = D.danceID";
    
        if ($username) {
            $sql .= " WHERE U.userName LIKE ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(["%$username%"]);
        } else {
            $stmt = $this->db->query($sql);
        }
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function updateTicketStatus($danceTicketID, $status) {
        $stmt = $this->db->prepare("UPDATE DanceTicket SET status = ? WHERE danceTicketID = ?");
        return $stmt->execute([$status, $danceTicketID]);
    }

 }