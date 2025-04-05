<main class="hf-payment-container">
  <section class="hf-payment-left">
    <h2>1. Enter an email address</h2>
    <input type="email" class="hf-input" placeholder="name@example.com" />
    <label class="hf-checkbox">
      <input type="checkbox" />
      Yes, I would like to receive updates about The Haarlem Festival.
    </label>

    <h2>2. Select a payment method</h2>

    <!-- iDEAL -->
    <div class="hf-payment-method">
      <button class="hf-payment-button" onclick="showPaymentMethod('ideal')">IDEAL</button>
      <div class="hf-payment-info" id="ideal-info" style="display: none;">
        <label for="hf-bank">Select Bank:</label>
        <select id="hf-bank" class="hf-input">
          <option>ING</option>
          <option>Rabobank</option>
          <option>ABN AMRO</option>
        </select>
        <p class="hf-note">iDEAL payments are processed securely via your bank.</p>
        <button class="hf-pay-btn">Continue to iDEAL</button>
      </div>
    </div>

    <!-- Credit Card -->
    <div class="hf-payment-method">
      <button class="hf-payment-button" onclick="showPaymentMethod('card')">Credit or Debit Card</button>
      <div class="hf-payment-info" id="card-info" style="display: none;">
        <div id="loading-message">Loading payment form...</div>
        <form id="payment-form" style="display: none;">
          <div id="payment-element" style="margin-bottom: 16px;"></div>
          <div id="payment-message" style="color: red; margin-bottom: 10px;"></div>
          <button type="submit" class="hf-pay-btn">Pay</button>
        </form>
      </div>
    </div>

    <!-- Crypto -->
    <div class="hf-payment-method">
      <button class="hf-payment-button" onclick="showPaymentMethod('crypto')">Cryptocurrency</button>
      <div class="hf-payment-info" id="crypto-info" style="display: none;">
        <p class="hf-note">Cryptocurrency payments are processed via third-party providers.</p>
        <button class="hf-pay-btn">Continue</button>
      </div>
    </div>
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

    <!-- No need for a duplicate total -->
  </aside>
</main>

<script src="https://js.stripe.com/v3/"></script>
<script>
let stripe;
let elements;
let paymentMounted = false;

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
            console.error("❌ Invalid JSON from /create-payment:", raw);
            alert("Unexpected response:\n" + raw);
            return;
        }

        if (data.error) {
            alert("Stripe error: " + data.error);
            return;
        }

        // Initialize Stripe with clientSecret
        stripe = Stripe("<?= STRIPE_PUBLIC_KEY ?>");
        elements = stripe.elements({ clientSecret: data.clientSecret });

        // Update VAT and total with VAT in the order summary
        document.getElementById("vat-amount").textContent = data.vatAmount.toFixed(2);
        document.getElementById("total-with-vat").textContent = data.totalWithVat.toFixed(2);

    } catch (err) {
        console.error("❌ Failed to initialize Stripe:", err);
        alert("Stripe setup failed");
    }

    // Setup form submission
    const form = document.getElementById("payment-form");
    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: "http://localhost/payment-success"  // Redirect to this page on success
                }
            });

            if (error) {
                document.getElementById("payment-message").textContent = error.message;
            } else {
                // Send a request to backend to handle payment success
                const response = await fetch('/handle-payment-success', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        orderID: '<?= $_SESSION['order']['orderID'] ?>', // Send orderID from session
                        userID: '<?= $_SESSION['user']['userID'] ?>'  // Send userID from session
                    })
                });

                const data = await response.json();
                if (data.success) {
                    window.location.href = "/personal-program";  // Redirect after successful handling
                } else {
                    alert("There was an issue processing your payment.");
                }
            }
        });
    }
});

function showPaymentMethod(type) {
    // Hide all payment info sections
    ['ideal-info', 'card-info', 'crypto-info'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    });

    // Show selected method section
    const selectedEl = document.getElementById(`${type}-info`);
    if (selectedEl) {
        selectedEl.style.display = 'block';

        // Only mount Stripe Elements once
        if (type === 'card' && !paymentMounted && elements) {
            const paymentElement = elements.create("payment");
            paymentElement.mount("#payment-element");

            // Hide loader, show form
            document.getElementById("loading-message").style.display = "none";
            document.getElementById("payment-form").style.display = "block";

            paymentMounted = true;
        }
    }
}
</script>