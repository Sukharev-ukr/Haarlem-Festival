<?php
// routes/personalProgramRoute.php

require_once __DIR__ . '/../controllers/personalProgramController.php';

$controller = new personalProgramController();

// Personal Program Page
Route::add('/personal-program', function () use ($controller) {
    $controller->showPersonalProgram();
}, 'GET');

Route::add('/pay-now', function () {
    $controller = new PaymentController();
    $controller->handlePayNow(); // Call method to handle payment for pending order
}, 'POST');