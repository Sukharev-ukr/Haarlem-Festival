<?php
$error = $error ?? '';
$success = $success ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    /* Entire page background white */
    body {
      background-color: #fff; /* White background */
      margin: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    /* Dark card with white text */
    .card {
      background-color: #2d2f31; /* Dark background */
      color: #f8f9fa;           /* White text */
      border: none;
    }
    .card .form-label {
      color: #f8f9fa; /* White labels */
    }
  </style>
</head>
<body>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm p-4">
        <h3 class="card-title text-center mb-4">Register</h3>
        
        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="/user/register">
          <div class="mb-3">
            <label for="userName" class="form-label">User Name</label>
            <input 
              type="text" 
              name="userName" 
              id="userName" 
              class="form-control" 
              placeholder="Enter your username" 
              required
            >
          </div>
          <div class="mb-3">
            <label for="mobilePhone" class="form-label">Mobile Phone</label>
            <input 
              type="text" 
              name="mobilePhone" 
              id="mobilePhone" 
              class="form-control" 
              placeholder="Enter your phone number" 
              required
            >
          </div>
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
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input 
              type="password" 
              name="password" 
              id="password" 
              class="form-control" 
              placeholder="Enter your password" 
              required
            >
          </div>
          <!-- Add role or other fields if needed -->

          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <div class="text-center mt-3">
          <a href=
