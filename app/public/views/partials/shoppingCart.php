<?php
require_once(__DIR__ . "../../../controllers/CartController.php");
$userId = $_SESSION['user']['userID'] ?? null;

//if (!$userId) {
    //echo "<h3>User not logged in.</h3>";
    //exit;
//}

$cartController = new CartController();
$cartItems = $cartController->getCartItems($userId);
$totalPrice = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Haarlem Festival</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
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
                $itemDate = new DateTime($item['danceDate'] ?? $item['sessionDate'] ?? $item['reservationDate']);
                $day = $itemDate->format('l');
                if ($currentDay != $day) {
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
                        <?php else: ?>
                            <strong><?= $item['danceEvent'] ?? 'History Tour' ?></strong>
                            <p class="mb-0">
                                <?= $item['location'] ?? 'N/A' ?><br>
                                <?php if (isset($item['amountAdults'])): ?>
                                    Name: John Doe - Number of guests: <?= $item['amountAdults'] ?> Adults, <?= $item['amountChildren'] ?> Children
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="badge bg-primary"><?= $item['ticketType'] ?? 'Reservation Fee' ?> (<?= $item['TicketQuantity'] ?? 1 ?>x)</span>
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
            <button class="btn btn-success">Pay for selected event</button>
        </div>
    </div>
</section>

</body>
</html>
