<?php
// app_public/routes/index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
Route::add('/', function() {
    require_once __DIR__ . '/../controllers/IndexController.php';
    $controller = new IndexController();
    $controller->home();
}, 'get');

Route::add('/about', function() {
    require_once __DIR__ . '/../controllers/IndexController.php';
    $controller = new IndexController();
    $controller->about();
}, 'get');
