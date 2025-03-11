<?php
$error = $error ?? '';
$success = $success ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forgot Password</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- (Optional) reCAPTCHA JS if you want CAPTCHA on forgot page -->
  <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->

  <style>
    body {
      background-color:rgb(255, 255, 255); /* Dark background */
      color: #f8f9fa;           /* Light text */
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }
    .card {
      background-color: #2d2f31; /* Slightly lighter dark background */
      border: none;
    }
    .card .form-label {
      color: #f8f9fa;
    }
    .g-recaptcha {
      display: flex;
      justify-content: center;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm p-4">
        <h3 class="card-title text-center mb-4 text-white">Forgot Password</h3>
        
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="/user/forgot">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
              type="email" 
              name="email" 
              id="email" 
              class="form-control" 
              placeholder="Enter your email" 
              required
            >
          </div>

          <!-- Uncomment if you want reCAPTCHA here as well (dark theme) 
          <div class="mb-3 text-center">
            <div 
              class="g-recaptcha" 
              data-sitekey="<?= htmlspecialchars($_ENV['RECAPTCHA_SITE_KEY'] ?? 'YOUR_SITE_KEY') ?>" 
              data-theme="dark">
            </div>
          </div>
          -->

          <button type="submit" class="btn btn-primary w-100">Send</button>
        </form>

        <div class="text-center mt-3">
          <a href="/user/login" class="text-decoration-none text-info">Back to Login</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
