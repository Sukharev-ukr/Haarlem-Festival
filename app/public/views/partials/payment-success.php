<main class="hf-thankyou-container">
    <?php 
    echo '<pre>';
    print_r($orderItems);
    echo '</pre>';
        ?>
    <div class="hf-thankyou-card">
        <div class="hf-status-icon success">
            <img src="/assets/img/check-icon.png" alt="Success" width="80" />
        </div>
        <h2>Payment successful!</h2>
        <p class="hf-subtext">Thank you for your order.</p>

        <div class="hf-order-meta">
            <p><strong>Time / Date:</strong> <?= date("d-m-Y, H:i") ?></p>
            <p><strong>Ref number:</strong> <?= rand(100000000000, 999999999999) ?></p>
            <p><strong>Payment method:</strong> iDEAL</p>
            <p><strong>Sender Name:</strong> Haarlem Festival</p>
        </div>

        <div class="hf-ticket-list">
            <?php foreach ($orderItems as $item): ?>
                <div class="hf-ticket-item">
                    <div class="hf-ticket-info">
                        <strong><?= htmlspecialchars($item['restaurantName'] ?? $item['artistName']) ?></strong>
                        <p><?= htmlspecialchars($item['reservationDate'] ?? $item['danceDate']) ?></p>
                        <p><?= htmlspecialchars($item['restaurantLocation'] ?? $item['location']) ?></p>
                        <p class="hf-ticket-type"><?= htmlspecialchars($item['ticketType'] ?? 'Reservation Fee') ?></p>
                    </div>
                    <div class="hf-ticket-price">€<?= number_format($item['itemPrice'], 2) ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="hf-total">
            <p><strong>Taxpayer country:</strong> Netherlands</p>
            <p>21% VAT: €<?= number_format($vatAmount, 2) ?></p>
            <p class="hf-total-price">Total with VAT: €<?= number_format($totalWithVat, 2) ?></p>
        </div>

        <div class="hf-buttons">
            <a href="/" class="hf-btn">Return to Homepage</a>
        </div>
    </div>
</main>
