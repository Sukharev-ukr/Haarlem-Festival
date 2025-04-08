<?php
// controllers/PersonalProgramController.php

require_once __DIR__ . '/../models/PersonalProgramModel.php';

class PersonalProgramController
{
    private $model;

    public function __construct()
    {
        $this->model = new PersonalProgramModel();
    }

    public function showPersonalProgram()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userID = $_SESSION['user']['userID'] ?? null;

        if (!$userID) {
            header("Location: /user/login");
            exit;
        }

        $programItems = $this->model->getProgramItemsByUser($userID);
        require_once __DIR__ . '/../views/pages/PersonalProgram.php';
    }
}
