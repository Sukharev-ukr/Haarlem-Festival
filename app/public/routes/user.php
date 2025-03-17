<?php
// app/routes/user.php

// Registration
Route::add('/user/register', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->register();
}, ['get', 'post']);

// Email Verification
Route::add('/verify-email', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->verifyEmail();
}, 'get');

// Forgot Password
Route::add('/user/forgot', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->forgotPassword();
}, ['get', 'post']);

// Reset Password
Route::add('/user/reset', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->resetPassword();
}, ['get', 'post']);
Route::add('/user/login', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->login();
}, ['get', 'post']);

Route::add('/user/logout', function() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    session_destroy();
    header("Location: /");
    exit;
}, 'get');