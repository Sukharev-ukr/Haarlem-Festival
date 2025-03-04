<?php
// app_public/lib/error_reporting.php

if ($_ENV["ENV"] === "LOCAL") {
    // Show all errors
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // In production, log errors but don’t display them
    error_reporting(E_ALL);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/../../logs/php-error.log'); // example log path
}
