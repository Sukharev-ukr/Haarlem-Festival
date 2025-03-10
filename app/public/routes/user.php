<?php
// app_public/routes/user.php

// ---------------------------------------------
// LOGIN
// ---------------------------------------------
// GET => show login form
Route::add('/user/login', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->login();
}, 'get');

// POST => process login form
Route::add('/user/login', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->loginPost();
}, 'post');

// Registration
Route::add('/user/register', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->register();
}, ['get', 'post']);

// Forgot Password
Route::add('/user/forgot', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->forgotPassword();
}, ['get', 'post']);

// Forgot Password (GET/POST)
Route::add('/user/forgot', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->forgotPassword();
}, ['get','post']);

// ---------------------------------------------
// FORGOT PASSWORD
// ---------------------------------------------
// GET/POST => show forgot password form or process email
Route::add('/user/forgot', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->forgotPassword();
}, ['get','post']);

// ---------------------------------------------
// RESET PASSWORD
// ---------------------------------------------
// GET/POST => show reset form or set new password
Route::add('/user/reset', function() {
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->resetPassword();
}, ['get','post']);
