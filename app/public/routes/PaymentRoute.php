<?php

require_once __DIR__ . '/../controllers/PaymentController.php';

// to handle payment success
Route::add('/handle-payment-success', function () {
    $controller = new PaymentController();
    $controller->handlePaymentSuccess(); // Call the method to process payment success
}, 'POST');

Route::add('/payment', function () {
    $controller = new PaymentController();
    $controller->index();
}, 'get');

Route::add('/create-payment', function () {
    $controller = new PaymentController();
    $controller->createPaymentIntent();
}, 'post');

Route::add('/payment-success', function () {
    $controller = new PaymentController();
    $controller->showSuccess();
}, 'get');

Route::add('/handle-pay-later', function () {
    $controller = new PaymentController();
    $controller->handlePayLater();
}, 'POST');