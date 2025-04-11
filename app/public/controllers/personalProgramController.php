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

    // Displays the user's personal program page
    public function showPersonalProgram()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Get the user ID from the session
        $userID = $_SESSION['user']['userID'] ?? null;

        // If the user is not logged in, redirect to the login page
        if (!$userID) {
            header("Location: /user/login");
            exit;
        }

        // Fetch all personal program items for the logged-in user
        $programItems = $this->model->getProgramItemsByUser($userID);

        // Load the personal program view and pass the items to it
        require_once __DIR__ . '/../views/pages/PersonalProgram.php';
    }
}
