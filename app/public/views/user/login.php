<?php
$error = $error ?? '';
$success = $success ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google reCAPTCHA JS -->
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <style>
    /* Basic dark theme overrides */
    body {
      background-color:rgb(255, 255, 255); /* Dark background */
      color: #f8f9fa;           /* Light text */
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background-color:rgb(102, 97, 97); /* Slightly lighter dark background */
      border: none;
    }
    .card .form-label {
      color: #f8f9fa;
    }
    .g-recaptcha {
      /* Center the recaptcha widget */
      display: flex;
      justify-content: center;
    }
    /* reCAPTCHA in dark theme */
    .grecaptcha-badge { 
      visibility: hidden; /* Hide reCAPTCHA badge if desired (optional) */
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm p-4">
        <h3 class="card-title text-center mb-3 text-white">Login</h3>
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="/user/login">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input 
              type="email" 
              name="email" 
              id="email" 
              class="form-control" 
              placeholder="Enter your email" 
              required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input 
              type="password" 
              name="password" 
              id="password" 
              class="form-control" 
              placeholder="Enter your password" 
              required>
          </div>

          <!-- reCAPTCHA (dark theme) -->
          <div class="mb-3 text-center">
            <div 
              class="g-recaptcha" 
              data-sitekey="<?= htmlspecialchars($_ENV['RECAPTCHA_SITE_KEY'] ?? 'YOUR_SITE_KEY') ?>" 
              data-theme="dark">
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100">Login</button>

        </form>

        <div class="text-center mt-3">
          <a href="/user/forgot" class="text-decoration-none text-info">Forgot Password?</a><br>
          <a href="/user/register" class="text-decoration-none text-info">Don't have an account? Register</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
