<?php

require_once(__DIR__ . "/../controllers/DanceController.php");

Route::add('/dancePage', function () {
    $danceController = new DanceController();

    $fridayDances = $danceController->getDanceAtFriday(); // name fridayDances will be called at the dancePage.php
    $saturdayDances = $danceController->getDanceAtSaturday();
    $sundayDances = $danceController->getDanceAtSunday();
    require(__DIR__ . ("../../views/pages/dancePage.php"));
});

