<?php
// routes/index.php

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
