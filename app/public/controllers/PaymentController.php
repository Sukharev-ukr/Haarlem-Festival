<?php
require_once __DIR__ . '/../models/PaymentModel.php';
require_once __DIR__ . '/../models/CartModel.php';

class PaymentController {
    private $model;
    private $personalProgramModel;

    public function __construct() {
        $this->model = new PaymentModel();
        $this->personalProgramModel = new personalProgramModel();
    }

    public function index() {    
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    
        $orderId = $_GET['orderID'] ?? null;
    
        if (!$orderId) {
            die("No order ID provided.");
        }
    
        $cartModel = new CartModel();
    
        // Get order and items
        $order = $cartModel->getOrderById($orderId);
        $orderItems = $cartModel->getCartItemsByOrderID($orderId);
    
        if (!$order) {
            die("Order not found.");
        }
    
        // Update total in DB just to be safe
        $cartModel->updateOrderTotal($orderId);
    
        // Refresh order after update
        $order = $cartModel->getOrderById($orderId);
    
        // Store in session for later use in /create-payment
        $_SESSION['order'] = $order;
    
        // Make these available to the view
        require __DIR__ . '/../views/pages/payment.php';
    }

    public function createPaymentIntent() {
        header('Content-Type: application/json');
        $order = $_SESSION['order'] ?? null;
    
        if (!$order) {
            echo json_encode(['error' => 'No order found in session']);
            return;
        }
    
        require_once __DIR__ . '/../vendor/autoload.php'; // Load Stripe SDK
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    
        // Calculate VAT and total with VAT
        $orderTotal = $order['total']; // Assuming this is the net total
        $vatRate = 0.21; // 21% VAT for Netherlands
        $vatAmount = $orderTotal * $vatRate;
        $totalWithVat = $orderTotal + $vatAmount;
    
        try {
            // Create Stripe PaymentIntent with total including VAT
            $intent = \Stripe\PaymentIntent::create([
                'amount' => intval($totalWithVat * 100), // Convert to cents
                'currency' => 'eur',
                'metadata' => ['order_id' => $order['orderID']],
            ]);
    
            // Store VAT and total with VAT in session
            $_SESSION['vatAmount'] = $vatAmount;
            $_SESSION['totalWithVat'] = $totalWithVat;
    
            echo json_encode([
                'clientSecret' => $intent->client_secret,
                'vatAmount' => $vatAmount,
                'totalWithVat' => $totalWithVat
            ]);
        } catch (Exception $e) {
            error_log("❌ Stripe error: " . $e->getMessage());
            echo json_encode(['error' => 'Failed to create payment intent']);
        }
    }
    
    public function showSuccess() {
        // Ensure session data exists
        $order = $_SESSION['order'] ?? null;
    
        if (!$order) {
            die("No order in session.");
        }
    
        // Call handlePaymentSuccess() to process order and personal program
        $this->handlePaymentSuccess();
    }
    
    private function getAuthenticatedUserID() {
        $userID = $_SESSION['user']['userID'] ?? null;
        if (!$userID) {
            die("User not logged in.");
        }
        return $userID;
    }
    
    private function createPersonalProgram($userID, $orderID) {
        $programName = "Order #$orderID";
        return $this->personalProgramModel->createPersonalProgram($userID, $programName);
    }
    
    private function processOrderItems($orderItems, $programID) {
        foreach ($orderItems as $item) {
            $itemType = $this->determineItemType($item['bookingType']);
            $this->personalProgramModel->createPersonalProgramItem($programID, $item, $itemType);
    
            if ($itemType === 'Restaurant') {
                $this->adjustSlotCapacity($item);
            }
        }
    }
    
    private function determineItemType($bookingType) {
        switch ($bookingType) {
            case 'Restaurant': return 'Restaurant';
            case 'Dance': return 'Dance';
            case 'History': return 'History';
            default: return 'Unknown';
        }
    }
    
    private function adjustSlotCapacity($item) {
        $totalGuests = (int)$item['amountAdults'] + (int)$item['amountChildren'];
        $slotID = $item['slotID'] ?? null;
    
        if ($slotID && $totalGuests > 0) {
            $stmt = $this->model->getDB()->prepare("
                UPDATE RestaurantSlot
                SET capacity = capacity - :guests
                WHERE slotID = :slotID AND capacity >= :guests
            ");
            $stmt->execute([
                'guests' => $totalGuests,
                'slotID' => $slotID
            ]);
        }
    }

    private function sendInvoiceAndTickets($userID, $orderID, $orderItems) {
        require_once __DIR__ . '/../lib/pdfGenerator.php';
        require_once __DIR__ . '/../lib/mailer.php';
    
        // You might have a user model or method to fetch user info
        $userInfo = $this->model->getUserByID($userID); // You may need to implement this in PaymentModel
    
        $invoicePath = __DIR__ . "/../assets/invoice/invoice_$orderID.pdf";

        $invoiceItems = [];

        foreach ($orderItems as $item) {
            $description = $item['bookingType'] . ' - ';

            if ($item['bookingType'] === 'Restaurant') {
                $description .= $item['restaurantName'] ?? 'Restaurant Reservation';
            } elseif ($item['bookingType'] === 'Dance') {
                $description .= $item['artistName'] ?? 'Dance Event';
            } elseif ($item['bookingType'] === 'History') {
                $description .= 'History Tour';
            } else {
                $description .= 'Item';
            }

            $invoiceItems[] = [
                'description' => $description,
                'price' => $item['itemPrice'] ?? 0
            ];
        }
        generateInvoicePDF($orderID, $userInfo['username'], $invoiceItems, $invoicePath);

        // You can also generate ticket PDFs here if needed
        $ticketPaths = []; // Optional for now
    
        sendEmailAndTickets($userInfo['username'], $userInfo['email'], $invoicePath, $ticketPaths);
    }
    

    public function handlePaymentSuccess() {
        $userID = $this->getAuthenticatedUserID();
        $orderID = $_SESSION['order']['orderID'] ?? null;
    
        if (!$orderID) {
            die("Order ID not found.");
        }
    
        $cartModel = new CartModel();
        $orderItems = $cartModel->getCartItemsByOrderID($orderID);
    
        if (!$orderItems) {
            die("No order items found for this order.");
        }
    
        $programID = $this->createPersonalProgram($userID, $orderID);
        $this->processOrderItems($orderItems, $programID);
        $this->model->updateOrderStatusToPaid($orderID);
        $this->sendInvoiceAndTickets($userID, $orderID, $orderItems);
    
        header("Location: /personal-program");
        exit();
    }
    
}
