<?php

require_once(__DIR__ . "/../controllers/DanceController.php");

Route::add('/dancePage', function () {
    $danceController = new DanceController();

    $fridayDances = $danceController->getDancesByDate('2025-07-25');
    $saturdayDances = $danceController->getDancesByDate('2025-07-26');
    $sundayDances = $danceController->getDancesByDate('2025-07-27');

    require(__DIR__ . "../../views/pages/dancePage.php");
});

