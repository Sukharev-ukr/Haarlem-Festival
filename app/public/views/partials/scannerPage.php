<?php 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mobile Ticket Scanner</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://unpkg.com/html5-qrcode@2.3.8"></script>
  <link rel="stylesheet" href="../../assets/css/scanner.css">
  <script src="../../assets/js/scanner.js"></script>

</head>
<body>
  <div class="scanner-wrapper">
    <div class="scanner-title">🎫 Employee Ticket Scanner</div>
    <p class="text-muted">Point the camera at a QR code to check-in a ticket</p>

    <div id="reader"></div>
    <div id="statusMessage"></div>
    <div class="footer-note">Scanner will restart in 3s after each scan</div>
  </div>
</body>
</html>
