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
    
    public function handlePaymentSuccess() {
        // Fetch user data from session
        $userID = $_SESSION['user']['userID'] ?? null;
    
        if (!$userID) {
            die("User not logged in.");
        }
    
        // Fetch order data and items
        $orderID = $_SESSION['order']['orderID']; // Assuming it's stored in session
        $cartModel = new CartModel();
        $orderItems = $cartModel->getCartItemsByOrderID($orderID); // Get all order items for this order
    
        if (!$orderItems) {
            die("No order items found for this order.");
        }
    
        // Step 1: Create a new entry in PersonalProgram table
        $programName = "Order #$orderID"; // Program name can be based on the order ID
        $programID = $this->personalProgramModel->createPersonalProgram($userID, $programName); // Save it and get the program ID
    
        // Step 2: Loop through order items and insert into PersonalProgramItem table
        foreach ($orderItems as $item) {
            // Determine itemType based on bookingType
            $itemType = '';
            if ($item['bookingType'] === 'Restaurant') {
                $itemType = 'Restaurant';
            } elseif ($item['bookingType'] === 'Dance') {
                $itemType = 'Dance';
            } elseif ($item['bookingType'] === 'History') {
                $itemType = 'History';
            }
    
            // Save the program item with the correct itemType
            $this->personalProgramModel->createPersonalProgramItem($programID, $item, $itemType);
        }
    
        // Optional Step 3: Update order status to "paid" if necessary
        $this->model->updateOrderStatusToPaid($orderID);
    
        // Step 4: Redirect to the personal program page
        header("Location: /personal-program"); // Redirect to the user's personal program page
        exit();
    }    
}
