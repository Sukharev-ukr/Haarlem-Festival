<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>  
<nav class="navbar" style="background-color:rgb(0, 0, 0) !important; color: white;">
    <div class="container-fluid">
        <a class="navbar-brand" style="color: white;" href="/">My Site</a>
        <a class="nav-item nav-link active" href="/">Home Page</a>
        <a class="nav-item nav-link active" href="#">History</a>
        <a class="nav-item nav-link active" href="/dancePage">Dance</a>
        <a class="nav-item nav-link active" href="/restaurants">Dining</a>
        <a class="nav-item nav-link active" href="#">Magic Tyler</a>
        <div>
            <?php if (isset($_SESSION['user'])): ?>
                <a type="button" class="btn btn-primary" href="/user/logout">Logout</a>
            <?php else: ?>
                <a type="button" class="btn btn-primary" href="/user/login">Login/Register</a>
            <?php endif; ?>
        </div>
    </div>
</nav>
