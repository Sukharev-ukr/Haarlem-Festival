<?php

require_once __DIR__ . '/../vendor/autoload.php';

class PaymentModel extends BaseModel {
    public function __construct() {
        parent::__construct();
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
    }

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

    public function updateOrderStatusToPaid($orderID) {
        // Ensure order status is updated to "paid"
        $sql = "UPDATE `Order` SET status = 'paid' WHERE orderID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderID]);
    }
}
