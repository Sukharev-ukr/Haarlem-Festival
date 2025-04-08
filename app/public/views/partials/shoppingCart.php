<?php
require_once(__DIR__ . "../../../controllers/CartController.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: /user/login");
    exit;
}

$userId = $_SESSION['user']['userID'];

$cartController = new CartController();
$cartItems = $cartController->getCartItems($userId);
$unpaidOrderId = !empty($cartItems) ? $cartItems[0]['orderID'] ?? null : null;
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/shoppingCart.css">
    <script src="../../assets/js/shoppingCart.js"></script>
</head>

<body>
<section class="container mt-5">
    <h2 class="text-center mb-4 text-warning">SHOPPING CART</h2>

    <div class="cart-section shadow rounded mb-4 p-3 text-white">
        <h4 class="text-danger text-center">RESERVATION & BOOKING TICKET</h4>

        <?php if (count($cartItems) > 0): ?>
            <?php 
            $currentDay = '';
            foreach ($cartItems as $item): 
                $totalPrice += $item['itemPrice'];
                
                $fallbackDate = date('Y-m-d');
                $dateString = $item['danceDate'] ?? $item['sessionDate'] ?? $item['reservationDate'] ?? $fallbackDate;
                $itemDate = new DateTime($dateString);
                
                $day = $itemDate->format('l');
                if ($currentDay !== $day) {
                    $currentDay = $day;
                    echo "<h5 class='text-warning'>" . strtoupper($currentDay) . "</h5>";
                }
            ?>
            <div class="cart-item shadow rounded mb-3 p-2 text-white">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="date-box text-center">
                            <h5><?= $itemDate->format('D') ?></h5>
                            <h6><?= $itemDate->format('M j') ?></h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <?php if ($item['bookingType'] === 'Restaurant'): ?>
                            <strong>🍽️ <?= htmlspecialchars($item['restaurantName']) ?></strong>
                            <p class="mb-0">
                                Location: <?= htmlspecialchars($item['restaurantLocation']) ?><br>
                                Guests: <?= $item['amountAdults'] ?> Adults, <?= $item['amountChildren'] ?> Children<br>
                                <?php if (!empty($item['specialRequests'])): ?>
                                    Special request: <?= htmlspecialchars($item['specialRequests']) ?><br>
                                <?php endif; ?>
                                Date: <?= htmlspecialchars($item['reservationDate']) ?>
                            </p>
                        <?php elseif ($item['bookingType'] === 'Dance'): ?>
                            <strong>💃 <?= htmlspecialchars($item['artistName'] ?? 'Dance Event') ?></strong>
                            <p class="mb-0">
                                Location: <?= strip_tags($item['location'] ?? 'Unknown') ?><br>
                                Date: <?= htmlspecialchars($item['danceDate'] ?? '-') ?><br>
                                Time: <?= htmlspecialchars($item['startTime'] ?? '-') ?> - <?= htmlspecialchars($item['endTime'] ?? '-') ?>
                            </p>
                        <?php else: ?>
                            <strong>🎫 <?= htmlspecialchars($item['bookingType']) ?></strong>
                            <p class="mb-0">Details coming soon.</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-2 text-end">
                        <span class="badge bg-primary"><?= $item['ticketType'] ?? 'Reservation Fee' ?> (<?= $item['ticketQuantity'] ?? 1 ?>x)</span>
                        <p>€<?= number_format($item['itemPrice'], 2) ?></p>
                    </div>
                    <div class="col-md-2 text-end">
                        <button class="btn btn-danger remove-btn" data-id="<?= $item['orderItemID'] ?>">Remove</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <h5 class="text-center text-white">Your cart is empty!</h5>
        <?php endif; ?>

        <div class="total-section text-end mt-3">
            <h5>Total: <span id="total-price">€<?= number_format($totalPrice, 2) ?></span></h5>
            <?php if ($unpaidOrderId): ?>
                <a href="/payment?orderID=<?= $unpaidOrderId ?>" class="btn btn-success">Pay for selected event</a>
            <?php endif; ?>
        </div>
    </div>
</section>
</body>
</html>
