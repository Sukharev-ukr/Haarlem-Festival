<?php
$error = $error ?? '';
$success = $success ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Include reCAPTCHA JS if needed -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card mt-5 shadow-sm">
          <div class="card-body">
            <h3 class="card-title text-center mb-4">Forgot Password</h3>
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
              <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <form method="POST" action="/user/forgot">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
              </div>
              <!-- Uncomment if reCAPTCHA is enabled -->
              <!--
              <div class="mb-3">
                <div class="g-recaptcha" data-sitekey="<?= htmlspecialchars($_ENV['RECAPTCHA_SITE_KEY']) ?>"></div>
              </div>
              -->
              <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
            </form>
            <div class="mt-3 text-center">
              <a href="/user/login">Back to Login</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>
