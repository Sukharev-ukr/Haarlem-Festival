<main class="hf-payment-container">
  <section class="hf-payment-left">
    <h2>1. Enter an email address</h2>
    <input type="email" class="hf-input" placeholder="name@example.com" id="email" />
    <label class="hf-checkbox">
      <input type="checkbox" />
      Yes, I would like to receive updates about The Haarlem Festival.
    </label>

    <h2>2. Select a payment method</h2>

    <!-- Unified Pay Button (Stripe Checkout) -->
    <div class="hf-payment-method">
      <button class="hf-payment-button" id="pay-button">Pay with IDeal and Debit/Credit Card</button>
    </div>

    <!-- Pay Later Button -->
    <div class="hf-payment-method">
      <button class="hf-payment-button" id="pay-later-button">Pay Later</button>
    </div>
  </section>

  </section>

  <aside class="hf-order-summary">
    <h2>Order Overview</h2>
    <div class="hf-order-items">
      <?php foreach ($orderItems as $item): ?>
        <?php
          $isRestaurant = $item['bookingType'] === 'Restaurant';
          $isDance = $item['bookingType'] === 'Dance';

          $name = $isRestaurant ? $item['restaurantName'] : ($item['artistName'] ?? 'Unknown Artist');
          $location = $item['restaurantLocation'] ?? $item['location'] ?? 'Unknown Location';
          $date = $item['reservationDate'] ?? $item['danceDate'] ?? '';
          $time = $item['startTime'] ?? '';
          $type = $item['ticketType'] ?? 'Reservation Fee';
          $quantity = $item['ticketQuantity'] ?? 1;
          $price = $item['itemPrice'] ?? 0;
        ?>
        <div class="hf-item" style="background-color: #f8f8f8; padding: 12px 16px; border-radius: 10px; margin-bottom: 15px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
          <p style="font-weight: 600; margin-bottom: 4px;"><?= htmlspecialchars($name) ?></p>
          <p style="margin: 0;"><?= htmlspecialchars($location) ?></p>
          <?php if ($date): ?>
            <p style="margin: 0;"><?= htmlspecialchars(date("l, F j", strtotime($date))) ?><?= $time ? " at " . htmlspecialchars($time) : '' ?></p>
          <?php endif; ?>
          <?php if ($isRestaurant): ?>
            <p style="margin: 0;">Guests: <?= $item['amountAdults'] ?> Adults, <?= $item['amountChildren'] ?> Children</p>
            <?php if (!empty($item['specialRequests'])): ?>
              <p style="margin: 0;">Note: <?= htmlspecialchars($item['specialRequests']) ?></p>
            <?php endif; ?>
          <?php endif; ?>
          <?php if ($isDance): ?>
            <p style="margin: 0;">Ticket: <?= htmlspecialchars($type) ?> (<?= $quantity ?>x)</p>
          <?php endif; ?>
          <p style="margin-top: 8px; font-weight: bold;">€<?= number_format($price, 2) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- VAT Calculation -->
    <div>
      <p><strong>VAT (21%):</strong> €<span id="vat-amount"></span></p>
      <p><strong>Total with VAT:</strong> €<span id="total-with-vat"></span></p>
    </div>
  </aside>
</main>

<script src="https://js.stripe.com/v3/"></script>
<script>
// Initialize Stripe globally
let stripe;
let sessionId;

document.addEventListener("DOMContentLoaded", async () => {
    try {
        const res = await fetch('/create-payment', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=create_payment'
        });

        const raw = await res.text();
        let data;
        try {
            data = JSON.parse(raw);
        } catch (err) {
            console.error("Invalid JSON from /create-payment:", raw);
            alert("Unexpected response:\n" + raw);
            return;
        }

        if (data.error) {
            alert("Stripe error: " + data.error);
            return;
        }

        // Initialize Stripe with the public key
        stripe = Stripe("<?= STRIPE_PUBLIC_KEY ?>");

        // Update VAT and total with VAT in the order summary
        document.getElementById("vat-amount").textContent = data.vatAmount.toFixed(2);
        document.getElementById("total-with-vat").textContent = data.totalWithVat.toFixed(2);

        // Store sessionId for checkout
        sessionId = data.sessionId;

        // Add event listener to the Pay button
        document.getElementById("pay-button").addEventListener("click", startPayment);
        document.getElementById("pay-later-button").addEventListener("click", payLater);

    } catch (err) {
        console.error("Failed to initialize Stripe:", err);
        alert("Stripe setup failed");
    }
});

// Start payment and redirect to Stripe Checkout
async function startPayment() {
    if (!sessionId) {
        alert('Session ID is missing');
        return;
    }

    const { error } = await stripe.redirectToCheckout({
        sessionId: sessionId // sessionId returned by backend
    });

    if (error) {
        console.error('Error:', error);
    }
}

// Start Pay Later flow (use Pay Later with Klarna, Affirm, etc.)
async function payLater() {
    const res = await fetch('/handle-pay-later', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            orderID: '<?= $_SESSION['order']['orderID'] ?>',
            userID: '<?= $_SESSION['user']['userID'] ?>'
        })
    });

    const data = await res.json();
    if (data.success) {
        window.location.href = "/personal-program"; // Redirect after adding to personal program
    } else {
        alert("There was an issue adding your order to the personal program.");
    }
}

</script>
