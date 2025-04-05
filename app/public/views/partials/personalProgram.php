<div class="container mt-5">
  <h2 class="text-center mb-4">My Personal Program</h2>
  <script>
    console.log(<?= json_encode($programItems) ?>);
</script>
  <?php if (empty($programItems)): ?>
    <p class="text-center">You haven't booked anything yet.</p>
  <?php else: ?>
    <?php foreach ($programItems as $item): ?>
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title"><?= htmlspecialchars($item['itemType']) ?> Booking</h5>
          <p class="card-text">
            <?php if ($item['itemType'] === 'Restaurant'): ?>
              <strong>Restaurant:</strong> <?= htmlspecialchars($item['restaurantName'] ?? 'N/A') ?><br>
              <strong>Location:</strong> <?= htmlspecialchars($item['restaurantAddress'] ?? 'N/A') ?><br>
              <strong>Date:</strong> <?= htmlspecialchars($item['reservationDate'] ?? 'N/A') ?><br>
              <strong>Time:</strong> <?= htmlspecialchars($item['restaurantStartTime'] ?? 'N/A') ?> - <?= htmlspecialchars($item['restaurantEndTime'] ?? 'N/A') ?>
              <br><strong>Reservation Fee:</strong> €<?= number_format($item['reservationFee'] ?? 0, 2) ?>
            <?php elseif ($item['itemType'] === 'Dance'): ?>
              <strong>Dance Location:</strong> <?= htmlspecialchars($item['danceLocation'] ?? 'N/A') ?><br>
              <strong>Session Time:</strong> <?= htmlspecialchars($item['sessionTime'] ?? 'N/A') ?>
            <?php elseif ($item['itemType'] === 'History'): ?>
              <strong>Tour Location:</strong> <?= htmlspecialchars($item['historyLocation'] ?? 'N/A') ?><br>
              <strong>Session Time:</strong> <?= htmlspecialchars($item['sessionTime'] ?? 'N/A') ?>
            <?php endif; ?>
          </p>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
