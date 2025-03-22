<?php
require_once(__DIR__ . "/../../controllers/RestaurantController.php");
require_once(__DIR__ . "/../../controllers/ReservationController.php");

$restaurantID = $_GET['restaurantID'] ?? null;

if (!$restaurantID) {
    echo "<h3>Invalid restaurant ID.</h3>";
    exit;
}

$controller = new RestaurantController();
$restaurant = $controller->showRestaurantDetails($restaurantID);
$reservationController = new ReservationController();
$sessions = $reservationController->getAvailableSessions($restaurantID);

if (!$restaurant) {
    echo "<h3>Restaurant not found.</h3>";
    exit;
}

// Function to normalize special characters
function cleanStringForFilename($string) {
    $string = strtolower($string);
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string); // Convert special characters
    $string = preg_replace('/[^a-z0-9_]/', '', str_replace(' ', '_', $string)); // Keep only letters, numbers, and underscores
    return $string;
}

// Clean the restaurant name for filename usage
$restaurantName = cleanStringForFilename($restaurant['restaurantName'] ?? 'unknown');

// Define potential image paths
$imgPathJpg = "/assets/img/diningdetails/banner_{$restaurantName}.jpg";
$imgPathJpeg = "/assets/img/diningdetails/banner_{$restaurantName}.jpeg";

// Check which image file exists
if (file_exists($_SERVER['DOCUMENT_ROOT'] . $imgPathJpg)) {
    $imgPath = $imgPathJpg;
} elseif (file_exists($_SERVER['DOCUMENT_ROOT'] . $imgPathJpeg)) {
    $imgPath = $imgPathJpeg;
} else {
    $imgPath = "/assets/img/diningdetails/default_banner.jpg"; // Fallback if no image is found
}
?>

<div class="restaurant-detail-header">
    <!-- Back Button -->
    <button class="back-button" onclick="history.back()">← Go back</button>

    <!-- Banner Section -->
    <div class="restaurant-banner">
        <img src="<?= $imgPath ?>"
             alt="<?= htmlspecialchars($restaurant['restaurantName']) ?>"
             class="restaurant-banner-image">

        <!-- Transparent Overlay -->
        <div class="restaurant-banner-overlay">
            <h1 class="restaurant-title"><?= htmlspecialchars($restaurant['restaurantName']) ?></h1>
        </div>
    </div>
</div>
    <!-- Intro/Description -->
<div class="restaurant-description-section">
    <h2>Welcome to <?= htmlspecialchars($restaurant['restaurantName']) ?></h2>
    <p><?= nl2br(htmlspecialchars($restaurant['description'] ?? 'Description coming soon!')) ?></p>
</div>

<div class="reservation-container">
    <h2 class="reservation-title">Reservation</h2>

    <!-- Session Selection -->
    <div class="session-selection">
        <?php foreach ($sessions as $session): ?>
            <button type="button" class="session-btn" onclick="selectSlot(<?= $session['slotID'] ?>)">
                <?= htmlspecialchars($session["startTime"]) ?> - <?= htmlspecialchars($session["endTime"]) ?>
            </button>
        <?php endforeach; ?>
    </div>

<!-- Reservation Form -->
<form id="reservationForm" action="/reservation/make" method="POST">
    <input type="hidden" name="restaurantID" value="<?= $restaurantID ?>">
    <input type="hidden" id="selectedSlot" name="slotID" value="">

    <div class="reservation-form-container">
        <!-- LEFT SIDE (User Info) -->
        <div class="reservation-left">
            <div class="form-group">
                <label for="fullName">Full Name *</label>
                <input type="text" name="fullName" id="fullName" required>
            </div>

            <div class="form-group">
                <label for="phoneNumber">Phone Number *</label>
                <input type="text" name="phoneNumber" id="phoneNumber" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email">
            </div>

            <div class="form-group special-requests">
                <label for="specialRequests">Special Request</label>
                <textarea name="specialRequests" id="specialRequests" placeholder="Allergies, wheelchair access, etc."></textarea>
            </div>
        </div>

        <!-- RIGHT SIDE (Adults, Children, Date) -->
        <div class="reservation-right">
            <div class="form-group">
                <label for="adults">Adults *</label>
                <input type="number" name="adults" id="adults" min="1" value="1" required>
            </div>

            <div class="form-group">
                <label for="children">Children</label>
                <input type="number" name="children" id="children" min="0" value="0">
            </div>

            <div class="form-group reservation-calendar">
                <label>Select Date</label>
                <div id="inline-datepicker"></div>
                <input type="hidden" id="datepicker" name="reservationDate">
            </div>

            <div class="form-group pricing-info">
                <p>€ 35 p.p Adults</p>
                <p>€17.50 p.p (under 12 years old)</p>
            </div>
        </div>
    </div>

    <!-- Reservation Information -->
    <div class="reservation-info-box">
        <p><strong>Reservation Information</strong></p>
        <p>Reservations are mandatory. A reservation fee of €10 per person will be charged when booking through the Haarlem Festival website. This fee will be deducted from your final bill during your visit.</p>
    </div>

    <!-- Total Cost -->
    <div class="total-cost">
        <p>Total Cost: € <span id="totalPrice">0</span></p>
    </div>

    <!-- Buttons -->
    <div class="reservation-buttons">
        <button type="button" class="cart-btn">Go to Cart</button>
        <button type="submit" class="reserve-btn">Reserve</button>
    </div>
</form>

</div>

<script>
    $(document).ready(function() {
        $("#inline-datepicker").datepicker({
            dateFormat: "dd-mm-yy",
            minDate: 0, // Prevent past dates
            showAnim: "fadeIn",
            onSelect: function(dateText) {
                $("#datepicker").val(dateText); // Store selected date in the hidden input
            }
        });

        // Default value for hidden input (in case user does not change it)
        $("#datepicker").val($("#inline-datepicker").datepicker("getDate"));
    });

function selectSlot(slotID) {
    document.getElementById("selectedSlot").value = slotID;
}
</script>
