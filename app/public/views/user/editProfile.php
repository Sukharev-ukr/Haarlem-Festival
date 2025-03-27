<?php require(__DIR__ . '/../partials/header.php'); ?>

<div class="container my-5">
  <h2 class="mb-4 text-center">Manage Account</h2>

  <!-- Display success message if set -->
  <?php if (!empty($success)): ?>
    <div class="alert alert-success text-center" role="alert">
      <?= htmlspecialchars($success) ?>
    </div>
  <?php endif; ?>

  <!-- Display error message if set -->
  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= htmlspecialchars($error) ?>
    </div>
  <?php endif; ?>

  <!-- Use a row to center the form and limit width -->
  <div class="row justify-content-center">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
      <form action="/user/editProfile" method="POST">
        <!-- Email -->
        <div class="mb-3">
          <label for="email" class="form-label">Edit E-mail</label>
          <input 
            type="email" 
            name="email" 
            id="email" 
            class="form-control" 
            value="<?= htmlspecialchars($_SESSION['user']['Email'] ?? '') ?>" 
            required
          >
        </div>

        <!-- Name -->
        <div class="mb-3">
          <label for="userName" class="form-label">Edit Name</label>
          <input 
            type="text" 
            name="userName" 
            id="userName" 
            class="form-control" 
            value="<?= htmlspecialchars($_SESSION['user']['userName'] ?? '') ?>" 
            required
          >
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label for="password" class="form-label">Edit Password</label>
          <input 
            type="password" 
            name="password" 
            id="password" 
            class="form-control" 
            placeholder="Enter new password"
          >
          <small class="form-text text-muted">
            Leave blank if you don't want to change your password.
          </small>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require(__DIR__ . '/../partials/footer.php'); ?>
