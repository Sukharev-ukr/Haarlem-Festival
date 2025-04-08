<?php
require_once(__DIR__ . "/../models/EmployeeModel.php");

class EmployeeController {
    private $employeeModel;

    public function __construct() {
        $this->employeeModel = new EmployeeModel();
    }

    public function scanTicket($ticketID) {
        $ticket = $this->employeeModel->getTicketByQRCode($ticketID);
    
        if (!$ticket) {
            return ['success' => false, 'message' => 'Ticket not found.'];
        }
    
        if ($ticket['status'] === 'used') {
            return ['success' => false, 'message' => 'Ticket already scanned.'];
        }
    
        $this->employeeModel->markTicketAsUsed($ticketID);
        return ['success' => true, 'message' => 'Ticket validated successfully.'];
    }

    public function getDanceTickets($username = null) {
        return $this->employeeModel->getDanceTickets($username);
    }
    
    public function updateTicketStatus($danceTicketID, $status) {
        return $this->employeeModel->updateTicketStatus($danceTicketID, $status);
    }
    

}