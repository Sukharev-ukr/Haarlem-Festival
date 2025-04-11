<?php

// Load Composer dependencies (including Stripe)
require_once __DIR__ . '/../vendor/autoload.php';

class PaymentModel extends BaseModel {
    public function __construct() {
        parent::__construct();
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    }

    // Creates a Stripe PaymentIntent for a specific order
    public function createPaymentIntent($orderId, $amount, $currency = 'eur') {
        try {
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => [
                    'order_id' => $orderId
                ]
            ]);
    
            return [
                'success' => true,
                'clientSecret' => $intent->client_secret
            ];
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }    

    // Marks the given order as "paid" in the database
    public function updateOrderStatusToPaid($orderID) {
        // Ensure order status is updated to "paid"
        $sql = "UPDATE `Order` SET status = 'paid' WHERE orderID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderID]);
    }

    // Gets the username and email of a user by their user ID (used for invoice emailing)
    public function getUserByID($userID) {
        $stmt = $this->getDB()->prepare("SELECT username, email FROM User WHERE userID = ?");
        $stmt->execute([$userID]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Marks the given order as "pending" (used when someone chooses 'pay later')
    public function updateOrderStatusToPending($orderID) {
        // Ensure order status is updated to "pending"
        $sql = "UPDATE `Order` SET status = 'pending' WHERE orderID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderID]);
    }
    
}
