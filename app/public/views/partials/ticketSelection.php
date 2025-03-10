<?php
require_once(__DIR__ . "/../../controllers/DanceController.php");

$danceID = $_GET['danceID'] ?? null;
$danceController = new DanceController();

$eventDetails = $danceController->getEventDetails($danceID);
$ticketDetails = $danceController->getTicketDetails($danceID);

if (!$eventDetails || !$ticketDetails) {
    echo "<h3>No details found for the selected event.</h3>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Selection - Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/ticketSelection.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="../../assets/js/ticketSelection.js"></script>
</head>

<body>

<section class="container mt-5">
    <h2 class="text-center mb-4 text-warning">SATURDAY</h2>

    <div class="event-details shadow rounded mb-4 p-3 text-white">
        <h4><?= $eventDetails['artists'] ?></h4>
        <p><i class="fa fa-calendar-alt me-2"></i><?= date('d/m/Y', strtotime($eventDetails['danceDate'])) ?> 
            <i class="fa fa-clock ms-3 me-2"></i><?= date('H:i', strtotime($eventDetails['startTime'])) ?> - <?= date('H:i', strtotime($eventDetails['endTime'])) ?></p>
        <p><i class="fa fa-map-marker-alt me-2"></i><?= $eventDetails['location'] ?></p>
    </div>

    <div class="ticket-options shadow rounded mb-4 p-3">
        <?php foreach ($ticketDetails as $index => $ticket): ?>
            
            <div class="ticket-type mb-2 p-2" data-price="<?= $ticket['ticketPrice'] ?>" data-type-id="<?= isset($ticket['ticketTypeId']) ? $ticket['ticketTypeId'] : '' ?>">

                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="text-white"><?= $ticket['ticketType'] ?></h5>
                        <p class="text-white">€<?= number_format($ticket['ticketPrice'], 2) ?></p>
                    </div>
                    <div class="col-md-3 text-center">
                        <button class="btn btn-outline-light btn-sm decrement" data-index="<?= $index ?>">-</button>
                        <span class="px-2 text-white ticket-count" id="ticket-count-<?= $index ?>">0</span>
                        <button class="btn btn-outline-light btn-sm increment" data-index="<?= $index ?>">+</button>
                    </div>
                    <div class="col-md-3 text-end">
                        <p class="text-white ticket-total" id="ticket-total-<?= $index ?>">€0.00</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="total-section shadow rounded p-3 mb-4 text-white">
        <h5>Total (Inc Tax)</h5>
        <h3 id="total-price">€0.00</h3>
        <div class="text-end">
            <button class="btn btn-outline-light me-2" id="add-to-cart-btn">Add To Cart</button>
            <button class="btn btn-danger" id="buy-now-btn">Buy Now</button>
        </div>
    </div>

</section>

</body>
</html>
