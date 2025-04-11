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
    
        // Update total in DB
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
    
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    
        // Calculate VAT and total with VAT
        $orderTotal = $order['total']; // Assuming this is the net total
        $vatRate = 0.21; // 21% VAT for Netherlands
        $vatAmount = $orderTotal * $vatRate;
        $totalWithVat = $orderTotal + $vatAmount;
    
        try {
            // Create Stripe Checkout session
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['ideal', 'card'], // List of available methods
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => 'Order #' . $order['orderID'],
                            ],
                            'unit_amount' => intval(round($totalWithVat * 100)), // Convert to cents
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => 'http://localhost/payment-success?session_id={CHECKOUT_SESSION_ID}', // Ensure correct success URL
                'cancel_url' => 'http://localhost/payment-cancel',
                'metadata' => ['order_id' => $order['orderID']],
            ]);
    
            echo json_encode([
                'sessionId' => $checkout_session->id,
                'vatAmount' => $vatAmount,
                'totalWithVat' => $totalWithVat,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
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
            
            // Fix: Pass reservationID explicitly
            $reservationID = $item['reservationID'] ?? null;
    
            // Call createPersonalProgramItem with reservationID
            $this->personalProgramModel->createPersonalProgramItem($programID, $item, $itemType, $reservationID);
        
            if ($itemType === 'Restaurant') {
                $this->adjustSlotCapacity($item);
            }
        }
    }
    
    private function getOrderItems($orderID) {
        $cartModel = new CartModel();
        return $cartModel->getCartItemsByOrderID($orderID);
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
    
        // Ensure the invoice directory exists
        $invoiceDir = __DIR__ . "/../assets/invoice";
        if (!file_exists($invoiceDir)) {
            mkdir($invoiceDir, 0777, true);  // Create directory with write permissions
        }
    
        // Define the invoice path
        $invoicePath = $invoiceDir . "/invoice_$orderID.pdf";
    
        // You might have a user model or method to fetch user info
        $userInfo = $this->model->getUserByID($userID);
    
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
    
        // Generate the PDF
        generateInvoicePDF($orderID, $userInfo['username'], $invoiceItems, $invoicePath);
    
        // You can also generate ticket PDFs here if needed
        $ticketPaths = []; // Optional for now
    
        // Send email with invoice attached
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
    
        // ✅ Use the standardized logic
        $this->processOrderItems($orderItems, $programID);
    
        // ✅ Update payment status
        $this->model->updateOrderStatusToPaid($orderID);
    
        // ✅ Email confirmation
        $this->sendInvoiceAndTickets($userID, $orderID, $orderItems);
    
        header("Location: /personal-program");
        exit();
    }

    public function handlePayLater() {
        $userID = $this->getAuthenticatedUserID();
        $orderID = $_SESSION['order']['orderID'] ?? null;
    
        if (!$orderID) {
            die("Order ID not found.");
        }
    
        // Log for debugging
        error_log("User ID: $userID, Order ID: $orderID");
    
        // Save the order in the Personal Program (pending)
        $programID = $this->addToPersonalProgram($userID, $orderID);
    
        // Update order status to "pending"
        $this->model->updateOrderStatusToPending($orderID);
    
        // Log for debugging
        error_log("Program added: Program ID $programID");
    
        // Redirect to the personal program page
        header("Location: /personal-program");
        exit();
    }
    
    private function addToPersonalProgram($userID, $orderID) {
        // Create the personal program for the user
        $programID = $this->personalProgramModel->createPersonalProgram($userID, "Order #$orderID");
    
        // Get the order items
        $orderItems = $this->getOrderItems($orderID); // Ensure this function retrieves the order items
    
        // Log for debugging
        error_log("Adding items to program: Program ID $programID");
    
        // Loop through each order item and add it to the program
        foreach ($orderItems as $item) {
            // Determine the item type
            $itemType = $this->determineItemType($item['bookingType']);
            $this->personalProgramModel->createPersonalProgramItem($programID, $item, $itemType);
    
            // Log for debugging
            error_log("Item added: " . $item['orderItemID'] . " with type " . $itemType);
        }
    
        return $programID; // Return the program ID
    }

    // SINGLE ITEM
    public function handlePayNow() {
        $orderItemID = $_POST['orderItemID'] ?? null; // Retrieve orderItemID
        $userID = $_SESSION['user']['userID'] ?? null;
    
        if (!$orderItemID || !$userID) {
            die("Order Item ID or User ID missing.");
        }
    
        // Fetch the corresponding order item
        $cartModel = new CartModel();
        $orderItem = $cartModel->getOrderItemById($orderItemID); // Use the new method to fetch order item details
    
        if (!$orderItem || $orderItem['status'] !== 'pending') {
            die("Order Item not found or already paid.");
        }
    
        // Create a payment intent and redirect to Stripe checkout
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    
        try {
            // Create Stripe Checkout session
            $checkout_session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['ideal', 'card'], 
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => 'Order Item #' . $orderItem['orderItemID'], // Use orderItemID here
                            ],
                            'unit_amount' => $orderItem['total'] * 100, // Convert to cents (ensure 'total' is correct)
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => 'http://localhost/payment-success?session_id={CHECKOUT_SESSION_ID}', 
                'cancel_url' => 'http://localhost/payment-cancel',
                'metadata' => ['order_item_id' => $orderItem['orderItemID']], // Store orderItemID in metadata
            ]);
    
            echo json_encode(['sessionId' => $checkout_session->id]);
    
        } catch (\Stripe\Exception\ApiErrorException $e) {
            echo json_encode(['error' => 'Failed to create payment intent']);
        }
    }    
}
