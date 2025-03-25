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
    
        // ✅ Make sure variable matches what your view expects
        $programItems = $this->model->getProgramItemsByUser($userID);
    
        require_once __DIR__ . '/../views/pages/PersonalProgram.php';
    }
    


    // // USED THIS TO TEST WHEN LOGIN DIDN'T WORK --- You can ignore this, 
    // public function showPersonalProgram() {
    //     // TEMP: Hardcode a test user ID
    //     $testUserID = 1;
    
    //     $programItems = $this->model->getProgramItemsByUser($testUserID);
    //     require_once __DIR__ . '/../views/pages/PersonalProgram.php';
    // }
    
}
