<?php
// app_public/controllers/IndexController.php

class IndexController
{
    public function home()
    {
        // Render the homepage view
        // Make sure this file actually exists: app_public/views/home.php
        require_once __DIR__ . '/../views/pages/home.php';
    }

    public function about()
    {
        echo "<h1>About Page</h1>";
        echo "<p>This is the about page.</p>";
    }
}
