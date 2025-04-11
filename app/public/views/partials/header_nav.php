<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>  
<nav class="navbar" style="background-color:rgb(0, 0, 0) !important; color: white;">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: white;" href="/">Haarlem Festival</a>
        <a class="nav-item nav-link active" href="/">Home Page</a>
        <a class="nav-item nav-link active" href="/dancePage">Dance</a>
        <a class="nav-item nav-link active" href="/restaurants">Dining</a>
        <a class="nav-item nav-link active" href="/personal-program">Personal Program</a>
        <a class="nav-item nav-link active" href="/shoppingCart">Cart</a>
        <div>
        <?php if (isset($_SESSION['user'])): ?>
        <!-- Logout button -->
        <a class="btn btn-sm btn-outline-light me-2" href="/user/logout">Logout</a>
        <!-- Edit Profile button -->
        <a class="btn btn-sm btn-light text-dark" href="/user/editProfile">Edit Your Profile</a>
      <?php else: ?>
        <!-- If user is not logged in, show Login button -->
        <a class="btn btn-sm btn-outline-light" href="/user/login">Login</a>
      <?php endif; ?>
    </div>
</nav>
