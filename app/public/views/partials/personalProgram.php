<div class="container mt-5">
  <h2 class="text-center mb-4">My Personal Program</h2>

  <?php if (empty($programItems)): ?>
    <p class="text-center">You haven't booked anything yet.</p>
  <?php else: ?>
    <?php foreach ($programItems as $item): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">
            <?= htmlspecialchars($item['itemType']) ?> Booking
          </h5>
          <p class="card-text">
            <?php if ($item['itemType'] === 'Restaurant'): ?>
              <strong>Restaurant:</strong> <?= htmlspecialchars($item['restaurantName']) ?><br>
              <strong>Location:</strong> <?= htmlspecialchars($item['restaurantAddress']) ?><br>
              <strong>Date:</strong> <?= htmlspecialchars($item['reservationDate']) ?><br>
              <strong>Time:</strong>
              <?= date("H:i", strtotime($item['restaurantStartTime'] ?? '00:00')) ?> -
              <?= date("H:i", strtotime($item['restaurantEndTime'] ?? '00:00')) ?>
              <br><strong>Reservation Fee:</strong> €<?= number_format($item['reservationFee'], 2) ?>
              <br><strong>Base Price:</strong> €<?= number_format($item['basePrice'], 2) ?>
              <br><strong>Total:</strong> €<?= number_format($item['basePrice'] + $item['reservationFee'], 2) ?>
              <br><strong>Status:</strong> <?= htmlspecialchars($item['orderStatus']) ?>
            <?php elseif ($item['itemType'] === 'Dance'): ?>
              <strong>Dance Location:</strong> <?= htmlspecialchars($item['danceLocation']) ?><br>
              <strong>Session:</strong> <?= htmlspecialchars($item['sessionTime']) ?>
            <?php elseif ($item['itemType'] === 'History'): ?>
              <strong>Tour:</strong> <?= htmlspecialchars($item['historyLocation']) ?><br>
              <strong>Session:</strong> <?= htmlspecialchars($item['sessionTime']) ?>
            <?php endif; ?>
          </p>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>