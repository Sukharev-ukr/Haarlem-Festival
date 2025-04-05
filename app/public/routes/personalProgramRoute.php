<?php
// routes/personalProgramRoute.php

require_once __DIR__ . '/../controllers/personalProgramController.php';

$controller = new PersonalProgramController();

// Personal Program Page
Route::add('/personal-program', function () use ($controller) {
    $controller->showPersonalProgram();
}, 'GET');